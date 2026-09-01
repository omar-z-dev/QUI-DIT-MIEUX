<?php

/*
CONTROLEUR :
Rôle : extraire  et afficher une annonce avec sa photo principale
Paramètre : id de l'annonce
*/

require_once "libr/init.php";

// Connexion requise
require "libr/require_login.php";

// Récupérer l'id de l'annonce
$id = $_GET["id"] ?? 0;

//Charger l'annonce
$annonce = new annonce();
$annonce->load($id);


//Vérifier si annonce déja suivi par l'utilisateur
$suivi = new suivi();

// Vérifier si l'utilisateur est connecté
$utilisateurId = $_SESSION["id"] ?? null;

$estSuivie = $utilisateurId !== null
    ? $suivi->estSuivie($utilisateurId, $id)
    : false;


// Récupérer les catégories depuis l'API
$api = new api();
$categories = $api->getCategoryByCurl();

// Code catégorie de l'annonce
$codeCategorie = $annonce->value("categorie");

// Libellé catégorie venant de l'API
$libelleCategorie = $categories->{$codeCategorie};

// Charger la photo principale
$photo = new photo();
$photoPrincipale = $photo->getPhotoPrincipale($id);


// Chercher la meilleure enchère existante
$enchere = new enchere();
$meilleureEnchere = $enchere->getMeilleureEnchere($id);

// Afficher la page détail annonce
require "templates/pages/afficher-detail-annonce.php";
