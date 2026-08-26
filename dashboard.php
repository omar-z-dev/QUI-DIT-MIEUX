<?php
//role : afficher la page dashboard

//recuperer l'utilisateur connecté
$user = userConnected();

//instancier une recette
$recette = new recette();

//recuperer mes recettes
$mesRecettes = $recette->mesRecettes($user->id());

//recup les commetaire de l'utilisateur connecté

$commentaire = new commentaire();

$mesCommentaires = $commentaire->getCommentairesUtilisateur(
    userConnected()->id()
);

//recup les notes de l'utilisateur connecté
$note = new note();

$mesNotes = $note->getNotesUtilisateur(
    userConnected()->id()
);

//recup catalogue farine via l'api pour remplir la codelist des farine ds la rubrique cherhcehr une recette
$api = new api(); 
$catalogueFarines = $api->getCatalogueFarineByCurl();

// Afficher le template  
require "templates/pages/afficher-dashboard.php";