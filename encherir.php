<?php

/*
Rôle : enregistrer une enchère sur une annonce

Paramètres :
- annonce_id
- montant
*/

require_once "libr/init.php";

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION["id"])) {
    header("Location: auth.php?action=login");
    exit;
}

// Récupérer les données du formulaire
$annonceId = $_POST["annonce_id"] ?? 0;
$montant   = $_POST["montant"] ?? "";


// Vérifier les données
if (empty($annonceId) || $montant === "") {

    $_SESSION["error_enchere"] = "Montant invalide ❌";
    header("Location: index.php");
    exit;
}


// Vérifier que le montant est numérique
if (!is_numeric($montant) || $montant <= 0) {

    $_SESSION["error_enchere"] = "Montant invalide ❌";
    header("Location: detail-annonce.php?id=" . $annonceId);
    exit;
}

// Charger l'annonce
$annonce = new annonce();

if (!$annonce->load($annonceId)) {
    header("Location: index.php");
    exit;
}

// Vérifier que l'utilisateur n'enchérit pas sur sa propre annonce
if ($annonce->value("utilisateur_id") == $_SESSION["id"]) {

    $_SESSION["error_enchere"] =
        "Vous ne pouvez pas enchérir sur votre propre annonce ❌";

    header("Location: detail-annonce.php?id=" . $annonceId);
    exit;
}

// Vérifier que la vente n'est pas terminée
if (strtotime($annonce->value("date_fin")) <= time()) {

    $_SESSION["error_enchere"] =
        "Cette vente est terminée ❌";
    header("Location: detail-annonce.php?id=" . $annonceId);
    exit;
}

// Chercher la meilleure enchère existante
$enchere = new enchere();

$meilleureEnchere = $enchere->getMeilleureEnchere($annonceId);


// Si aucune enchère n'existe encore
if (!$meilleureEnchere) {

    if ($montant <= $annonce->value("prix_depart")) {

        $_SESSION["error_enchere"] =
            "Votre enchère doit être supérieure au prix de départ ❌";

        header("Location: detail-annonce.php?id=" . $annonceId);
        exit;
    }
}

// Si une enchère existe déjà
else {

    if ($montant <= $meilleureEnchere->value("montant")) {

        $_SESSION["error_enchere"] =
            "Votre enchère doit être supérieure à l'enchère actuelle ❌";
        header("Location: detail-annonce.php?id=" . $annonceId);
        exit;
    }
}

// Créer la nouvelle enchère
$nouvelleEnchere = new enchere();

$nouvelleEnchere->set("annonce_id", $annonceId);
$nouvelleEnchere->set("utilisateur_id", $_SESSION["id"]);
$nouvelleEnchere->set("montant", $montant);
$nouvelleEnchere->set(
    "date_enchere",
    date("Y-m-d H:i:s")
);

// Insérer en BDD
$resultat = $nouvelleEnchere->insert();

// Si succès
if ($resultat) {

    $_SESSION["success_enchere"] =
        "✅ Votre enchère a bien été enregistrée";

    header("Location: detail-annonce.php?id=" . $annonceId);
    exit;
}

// Si erreur
$_SESSION["error_enchere"] =
    "Erreur lors de l'enregistrement de l'enchère ❌";

header("Location: detail-annonce.php?id=" . $annonceId);
exit;