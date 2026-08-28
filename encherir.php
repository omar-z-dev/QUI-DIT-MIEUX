<?php

/*

Rôle : enregistrer une enchère sur une annonce

Paramètres :
- annonce_id
- montant

*/

// Initialisation
require_once "libr/init.php";

// Récupérer les données du formulaire
$annonceId = $_POST["annonce_id"] ?? 0;
$montant   = $_POST["montant"] ?? "";

// Vérifier les données
if (empty($annonceId) || $montant === "") {

    $_SESSION["enchere"] = "Montant invalide ❌";
    header("Location: voir-detail-annonce.php?id=" . $annonceId);
    exit;
}


// Vérifier que le montant est numérique
if (!is_numeric($montant) || $montant <= 0) {

    $_SESSION["enchere"] = "Montant invalide ❌";
    header("Location: voir-detail-annonce.php?id=" . $annonceId);
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

    $_SESSION["enchere"] =
        "Vous ne pouvez pas enchérir sur votre propre annonce ❌";

    header("Location: voir-detail-annonce.php?id=" . $annonceId);
    exit;
}

// Vérifier que la vente n'est pas terminée
if (strtotime($annonce->value("date_fin")) <= time()) {

    $_SESSION["enchere"] =
        "Cette vente est terminée ❌";
    header("Location: voir-detail-annonce.php?id=" . $annonceId);
    exit;
}

// Chercher la meilleure enchère existante
$enchere = new enchere();

$meilleureEnchere = $enchere->getMeilleureEnchere($annonceId);


// Si aucune enchère n'existe encore
if (!$meilleureEnchere) {

    if ($montant <= $annonce->value("prix_depart")) {

        $_SESSION["enchere"] =
            "Votre enchère doit être supérieure au prix de départ ❌";

        header("Location: voir-detail-annonce.php?id=" . $annonceId);
        exit;
    }
}

// Si une enchère existe déjà
else {

    if ($montant <= $meilleureEnchere->value("montant")) {

        $_SESSION["enchere"] =
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
$nouvelleEnchere->set("date_enchere",date("Y-m-d H:i")
);

// Insérer en BDD
$resultat = $nouvelleEnchere->insert();

// Si succès
if ($resultat) {

    $_SESSION["enchere"] =
        "✅ Votre enchère a bien été enregistrée";

    header("Location: voir-detail-annonce.php?id=" . $annonceId);
    exit;
}

// Si erreur
$_SESSION["enchere"] =
    "Erreur lors de l'enregistrement de l'enchère ❌";

header("Location: detail-annonce.php?id=" . $annonceId);
exit;