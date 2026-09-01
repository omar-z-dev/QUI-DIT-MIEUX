<?php

/*

CONTROLEUR :
Rôle : Insérer un enregistrement dans la table suivi avec l'id de l'utilisateur et l'id de l'annonce losque on clique sur suivre l'annonce
param : annonce_id

*/

require_once "libr/init.php";

// Récupérer l'id de l'annonce
$annonceId = $_POST["annonce_id"] ?? 0;

// Charger l'annonce
$annonce = new annonce();

// Empêcher de suivre sa propre annonce
if ($annonce->value("utilisateur_id") == $_SESSION["id"]) {

    $_SESSION["suivi"] =
        "Vous ne pouvez pas suivre votre propre annonce.";
    header("Location: detail-annonce.php?id=" . $annonceId);
    exit;
}

// Objet suivi
$suivi = new suivi();

// Vérifier si l'annonce est déjà suivie (controle aussi mis en place dans la page en question) 
if ($suivi->estSuivie($_SESSION["id"], $annonceId)) {

    $_SESSION["suivi"] =
        "Vous suivez déjà cette annonce.";
    header("Location: detail-annonce.php?id=" . $annonceId);
    exit;
}

// Enregistrer le suivi
$suivi->set("utilisateur_id", $_SESSION["id"]);
$suivi->set("annonce_id", $annonceId);
$suivi->set("date_suivi", date("Y-m-d H:i"));

// Insérer le suivi dans la base de données
$resultat = $suivi->insert();

// Message
if ($resultat) {

    $_SESSION["suivi"] =
        "Annonce ajoutée à vos suivis ⭐";
} else {

    $_SESSION["suivi"] =
        "Erreur lors du suivi de l'annonce.";
}

// Retourner sur l'annonce
header("Location: detail-annonce.php?id=" . $annonceId);
exit;