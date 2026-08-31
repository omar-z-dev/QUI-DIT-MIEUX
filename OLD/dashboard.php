<?php
/*

CONTROLEUR :
Rôle : afficher la page dashboard de l'utilisateur connecté
param : néant

*/

//Initialisations diverses
require_once "libr/init.php";

//Charger l'utilisateur connecté
$utilisateur = userConnected();

//Récupérer les enchères de l'utilisateur connecté
$enchere     = new enchere();
$mesEncheres = $enchere->getEncheresByUtilisateur($utilisateur->id());

//instancier une annonce pour recuperer les annonces de l'utilisateur connecté
$annonce     = new annonce();
$mesAnnonces = $annonce->listAllByUser($utilisateur->id());


//Recuperer le dernier prix proposé pour chaque annonce de l'utilisateur connecté si dispo sinon recuperer le prix de l'annonce
foreach($mesAnnonces as $annonce){
    $meilleureEnchere = $enchere->getMeilleureEnchere(
        $annonce->id()
    );
    if($meilleureEnchere){
        $dernierPrix = $meilleureEnchere->value("montant");
    }else{
        $dernierPrix = $annonce->value("prix_depart");
    }
    //stocker le dernier prix avec l'ID de l'annonce
    $derniersPrix[$annonce->id()] = $dernierPrix;

    // Déterminer le statut de l'annonce : en cours, vendu ou pas vendu
    if(strtotime($annonce->value("date_fin"))>time()){
        $statuts[$annonce->id()] = "En cours";
    }elseif($meilleureEnchere){
        $statuts[$annonce->id()] = "Vendu";
    }else{
        $statuts[$annonce->id()] = "Pas vendu";
    }
}

// recup de toutes les annonces sauf celles de l'utilisateur connecté
$ListeAnnonces = $annonce->listOtherAnnonces($utilisateur->id());

//Instacier un objet api
$api = new api();

//Récupérer ttes les categories
$categories = $api->getCategoryByCurl();

//Récupérer les annonces suivi  de l'utilisateur connecté
$suivi     = new suivi();
$mesSuivis = $suivi->getSuivisByUtilisateur($utilisateur->id()
);

//Afficher le template  
require "templates/pages/afficher-dashboard.php";