<?php

/*
Rôle : extraire  et afficher une annonce avec sa photo principale
Paramètre : id de l'annonce
*/

require_once "libr/init.php";

// Récupérer l'id de l'annonce
$id = $_GET["id"] ?? 0;

//Charger l'annonce
$annonce = new annonce();
$annonce->load($id);


//Vérifier si annonce déja suivi par l'utilisateur
$suivi = new suivi();

if ($suivi->estSuivie($_SESSION["id"], $id)) {
    $estSuivie = true;
} else {
    $estSuivie = false;
}


// Code catégorie de l'annonce
$codeCategorie = $annonce->value("categorie");

// Récupérer les catégories depuis l'API
$api = new api();
$categories = $api->getCategoryByCurl();

// Libellé catégorie venant de l'API
$libelleCategorie = $categories->{$codeCategorie};

// Charger la photo principale
$photo = new photo();

$photoPrincipale = $photo->getPhotoPrincipale($id);

// Afficher la page
require "templates/pages/afficher-detail-annonce.php";
