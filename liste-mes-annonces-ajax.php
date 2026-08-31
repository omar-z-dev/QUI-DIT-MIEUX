<?php

require_once "libr/init.php";

//Charger l'utilisateur connecté
$utilisateur = userConnected();

// Récupérer les annonces de l'utilisateur
$annonce = new annonce();
$mesAnnonces = $annonce->listAllByUser($utilisateur->id());

// Tableaux
$derniersPrix = [];
$statuts      = [];

// Objet enchère
$enchere = new enchere();

// Parcourir les annonces
foreach($mesAnnonces as $annonce){

    // Récupérer la meilleure enchère
    $meilleureEnchere = $enchere->getMeilleureEnchere($annonce->id());

    // Dernier prix
    if($meilleureEnchere){
        $derniersPrix[$annonce->id()] = $meilleureEnchere->value("montant");
    }else{
        //stocker le dernier prix avec l'ID de l'annonce
        $derniersPrix[$annonce->id()] = $annonce->value("prix_depart");
    }

    // Statut
    if(strtotime($annonce->value("date_fin")) > time()){
        $statuts[$annonce->id()] = "En cours";
    }elseif($meilleureEnchere){
        $statuts[$annonce->id()] = "Vendu";
    }else{
        $statuts[$annonce->id()] = "Non vendu";
    }
}

// Retourner directement le HTML de la table
require "templates/fragments/table-mes-annonces.php";