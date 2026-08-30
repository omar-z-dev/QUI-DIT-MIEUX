<?php

/*

CONTROLEUR :

Rôle : supprimer une photo d'une annonce

Paramètres GET :
- id : identifiant de la photo
- annonce_id : identifiant de l'annonce

*/

require_once "libr/init.php";

// Récupérer les identifiants
$photoId   = $_GET["id"] ?? 0;
$annonceId = $_GET["annonce_id"] ?? 0;


// Charger la photo
$photo = new photo();

if (!$photo->load($photoId)) {
    $_SESSION["error_annonce"]="Photo introuvable ❌";
    header("Location: dashboard.php");
    exit;
}

// Charger l'annonce
$annonce = new annonce();

if (!$annonce->load($annonceId)) {
    $_SESSION["error_annonce"]="Annonce introuvable ❌";
    header("Location: dashboard.php");
    exit;
}

// Récupérer le nom du fichier avant suppression
$fichier = $photo->value("fichier");
// Supprimer l'enregistrement dans la base
$photo->delete();

// Supprimer le fichier physique
$chemin="img/".$fichier;

if (file_exists($chemin)) {
    unlink($chemin);
}

// Message succès
$_SESSION["annonce"]="Photo supprimée avec succès ✅";

// Retour vers le formulaire de modification
header("Location: modifier-annonce.php?id=".$annonceId);
exit;