<?php

require_once "libr/init.php";

// Récupérer les critères
$texte     = trim($_GET["texte"] ?? "");
$categorie = $_GET["categorie"] ?? "";
$etat      = $_GET["etat"] ?? "";
$prix      = $_GET["prix"] ?? "";
$vente     = $_GET["vente"] ?? "";

$annonce = new annonce();

$resultats = $annonce->rechercherAnnonces(
    $texte,
    $categorie,
    $etat,
    $prix,
    $vente
);

require "templates/pages/afficher-resultats-recherche.php";