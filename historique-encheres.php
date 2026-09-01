<?php

/*

CONTROLEUR :
Rôle : afficher la page voir-historique-encheres.php
param: annonce_id

*/

// Initialisation
require_once "libr/init.php";

// ID de l'utilisateur connecté
$utilisateurId = $_SESSION["id"];

// Récupérer l'id de l'annonce
$annonceId = $_GET["id"] ?? "";

// Instancier un objet enchere
$enchere = new enchere();

// Vérifier si l'utilisateur a enchéri sur cette annonce
$aEncheri = $enchere->utilisateurAEncheri($annonceId,$utilisateurId);

// Charger l'annonce
$annonce = new annonce($annonceId);
// Vérifier si l'utilisateur est le vendeur
$estVendeur = $annonce->value("utilisateur_id") == $utilisateurId;

// Si l'utilisateur n'est ni vendeur ni enchérisseur
if (!$estVendeur && !$aEncheri) {

    $_SESSION["error"] ="Vous n'avez pas accès à l'historique des encheres de cette annonce ❌";
    header("Location: dashboard.php");
    exit;
}
// Récupérer l'historique
$ListeEncheres = $enchere->getEncheresByAnnonce($annonceId);

// Affichage
require_once "templates/pages/afficher-historique-encheres.php";