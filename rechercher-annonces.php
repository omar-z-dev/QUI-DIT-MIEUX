<?php

/*

CONTROLEUR :
Rôle : rechercher des annonces selon différents critères

Paramètres GET :
- texte
- categorie
- etat
- prix
- vente

*/

require_once "libr/init.php"; 

// Récupérer les paramètres
$texte     = trim($_GET["texte"]??"");
$categorie = trim($_GET["recherche_categorie"]??"");
$etat      = $_GET["etat"]??"";
$prix      = $_GET["prix"]??"";
$vente     = $_GET["vente"]??"";


/*===================================================================
    RECHERCHER LES CATÉGORIES (retour:tableau des code des catégories trouvées)
====================================================================*/

// Instancier l'objet API
$api = new api();

// Si l'utilisateur a saisi une catégorie
if(!empty($categorie)){

    // Rechercher les catégories correspondantes via l'API
    $categoriesTrouvees = $api->rechercherCategories($categorie);

    // Récupérer uniquement les codes des catégories
    $categorie = array_keys($categoriesTrouvees);
}
// Si aucune catégorie n'a été saisie
else{
    $categorie=[];
}

/*==============================
    RECHERCHER LES ANNONCES
================================*/

$annonce = new annonce();

// Récupérer les annonces correspondantes
$ListeAnnonces = $annonce->rechercherCategoriesByCriteres($texte,$categorie,$etat,$prix,$vente);
  
// Créer les objets photo et enchere
$photo   = new photo();
$enchere = new enchere();

// Tableaux contenant les informations de chaque annonce
$photosPrincipales = [];
$prixCourants      = [];

foreach($ListeAnnonces as $annonce){

    // Récupérer l'ID de l'annonce actuelle
    $annonceId = $annonce->id();

    // Récupérer la photo principale ($photoPrincipale contient un objet photo)
    $photoPrincipale = $photo->getPhotoPrincipale($annonceId);

    // Stocker la photo (Objet photo)avec l'ID de l'annonce
    $photosPrincipales[$annonceId] = $photoPrincipale;

    // Récupérer la meilleure enchère
    $meilleureEnchere = $enchere->getMeilleureEnchere($annonceId);

    // Déterminer le prix courant
    if($meilleureEnchere){
        $prixCourant = $meilleureEnchere->value("montant");

    }else{
        $prixCourant = $annonce->value("prix_depart");
    }

    // Stocker le prix avec l'ID de l'annonce
    $prixCourants[$annonceId] = $prixCourant;
}

/*echo "<pre>";
print_r($ListeAnnonces);
echo "</pre>";*/

require "templates/pages/afficher-resultats-recherche.php";