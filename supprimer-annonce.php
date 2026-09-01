<?php

/*

CONTROLEUR :
Rôle : supprimer une annonce

Paramètre :
- id : identifiant de l'annonce à supprimer

*/

// Initialisation
require_once "libr/init.php";

// Connexion requise
require "libr/require_login.php";

// Récupérer l'id de l'annonce
$id = $_GET["id"] ?? 0;

// Charger l'annonce
$annonce = new annonce($id);

// Vérifier que l'annonce appartient bien à l'utilisateur connecté meme si le bouton supprimer est disponible que pour les annonces de l'utilisateur connecté

if ($annonce->value("utilisateur_id") != $_SESSION["id"]) {
    $_SESSION["annonce"] = "Vous ne pouvez pas supprimer cette annonce ❌";
    header("Location: dashboard.php");
    exit;
}
// Vérifier s'il existe une enchère sur cette annonce
$enchere=new enchere();

$meilleureEnchere=$enchere->getMeilleureEnchere($id);

// Si une enchère existe, empêcher la suppression
if ($meilleureEnchere) {
    $_SESSION["annonce"]='Impossible de supprimer l\'annonce "'.
        $annonce->html("titre").
        '" car une enchère existe déjà ❌';

    header("Location: dashboard.php");
    exit;
}


// Supprimer l'annonce
$resultat = $annonce->delete();

// Vérifier le résultat
if ($resultat) {

    $_SESSION["success_annonce"] = "Annonce supprimée avec succès ✅";
} else {
    $_SESSION["success_annonce"] = "Erreur lors de la suppression de l'annonce ❌";
}

// Redirection
header("Location: dashboard.php");
exit;