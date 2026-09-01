<?php

/*

CONTROLEUR :
Rôle : récupérer et actualiser les annonces suivies de l'utilisateur connecté

Paramètres : neant

*/

// Initialisations
require_once "libr/init.php";

// Connexion requise
require "libr/require_login.php";

// Récupérer l'utilisateur connectés
$utilisateur = userConnected();

$suivi = new suivi();
$mesSuivis = $suivi->getSuivisByUtilisateur($utilisateur->id());

$enchere = new enchere();

$prixCourantsAll = [];
$nombreEncheres  = [];
$vendeurs        = [];
$statutsEncheres = [];

foreach ($mesSuivis as $suivi) {

    // Récupérer l'annonce
    $annonce = $suivi->get("annonce_id");
    $annonceId = $annonce->id();

    // Récupérer la meilleure enchère
    $meilleureEnchere = $enchere->getMeilleureEnchere($annonceId);

    // Déterminer le prix courant
    if ($meilleureEnchere) {
         /*Le prix courant = meilleure enchère*/
        $prixCourantsAll[$annonceId] = $meilleureEnchere->value("montant");
    } else {
        /*Sinon = prix de départ*/
        $prixCourantsAll[$annonceId] = $annonce->value("prix_depart");
    }

    // Compter le nombre d'enchères
    $nombreEncheres[$annonceId] = $enchere->countEncheresByAnnonce($annonceId);

    // vendeur : recuperer lobjet utilisateur d'un ID donné
    $vendeur = $annonce->get("utilisateur_id");

    // Stocker son pseudo
    $vendeurs[$annonceId] = $vendeur->value("pseudo");

    // Stocker l'historique des encheres
    $historiquesEncheres[$annonceId] = $enchere->getEncheresByAnnonce($annonceId);
}

// Afficher uniquement le tableau
require "templates/fragments/table-mes-suivis.php";