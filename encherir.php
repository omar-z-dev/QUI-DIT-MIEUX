<?php

/*

CONTROLEUR :
Rôle : enregistrer une enchère sur une annonce dans la BDD

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

    $_SESSION["enchere"] = "Montant doit etre un nombre positif ❌";
    header("Location: voir-detail-annonce.php?id=" . $annonceId);
    exit;
}

// Charger l'annonce
$annonce = new annonce();

// Charger l'annonce
$annonce->load($annonceId);

// Vérifier que l'utilisateur n'enchérit pas sur sa propre annonce meme si déja controle posé dans le html  ( btn encherir invisible si annonce de l'utilisateur)
if ($annonce->value("utilisateur_id") == $_SESSION["id"]) {

    $_SESSION["enchere"] =
        "Vous ne pouvez pas enchérir sur votre propre annonce ❌";
    header("Location: voir-detail-annonce.php?id=" . $annonceId);
    exit;
}

// Vérifier que la vente n'est pas terminée
if (strtotime($annonce->value("date_fin")) <= time()) {

    $_SESSION["enchere"] =
        "Cette vente est terminée, vous ne pouvez plus encherir ❌";
    header("Location: voir-detail-annonce.php?id=" . $annonceId);
    exit;
}

// Chercher la meilleure enchère existante
$enchere = new enchere();

$meilleureEnchere = $enchere->getMeilleureEnchere($annonceId);


// Si aucune enchère n'existe encore, vérifier que l'enchère est supérieure au prix de départ, sinon afficher un message d'erreur
if (!$meilleureEnchere) {

    if ($montant <= $annonce->value("prix_depart")) {

        $_SESSION["enchere"] =
            "Votre enchère doit être supérieure au prix de départ ❌";

        header("Location: voir-detail-annonce.php?id=" . $annonceId);
        exit;
    }
}

// Si une enchère existe déjà, vérifier que l'enchère est supérieure à l'enchère actuelle, sinon afficher un message d'erreur
else {

    if ($montant <= $meilleureEnchere->value("montant")) {

        $_SESSION["enchere"] =
            "Votre enchère doit être supérieure à l'enchère actuelle ❌";
        header("Location: voir-detail-annonce.php?id=" . $annonceId);
        exit;
    }
}

// Créer la nouvelle enchère
$nouvelleEnchere = new enchere();

// Remplir la nouvelle enchère
$nouvelleEnchere->set("annonce_id", $annonceId);
$nouvelleEnchere->set("utilisateur_id", $_SESSION["id"]);
$nouvelleEnchere->set("montant", $montant);
$nouvelleEnchere->set("date_enchere",date("Y-m-d H:i")
);

// Insérer en BDD la nouvelle enchère
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