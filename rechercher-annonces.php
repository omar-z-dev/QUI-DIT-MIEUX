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

// Récupérer les critères du formulaire
$texte     = trim($_GET["texte"]??"");
$categorie = trim($_GET["recherche_categorie"]??"");
$etat      = $_GET["etat"]??"";
$prix      = $_GET["prix"]??"";
$vente     = $_GET["vente"]??"";

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

// RECHERCHER LES ANNONCES

$annonce = new annonce();

$ListeAnnonces=$annonce->rechercherCategoriesByCriteres($texte,$categorie,$etat,$prix,$vente);

echo "<pre>";
print_r($ListeAnnonces);
echo "</pre>";

require "templates/pages/afficher-resultats-recherche.php";