<?php

/*
Rôle : afficher le détail d'une annonce avec sa photo principale
Paramètre : id de l'annonce
*/

require_once "libr/init.php";

// Récupérer l'id de l'annonce
$id = $_GET["id"] ?? 0;

//Charger l'annonce
$annonce = new annonce();

$annonce->load($id);

// Charger la photo principale
$photo = new photo();

$photoPrincipale = $photo->getPhotoPrincipale($id);

// Afficher la page
require "templates/pages/afficher-detail-annonce.php";
