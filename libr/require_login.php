<?php

// Code à inclure dans les controleurs pour imposer la connexion


// Si on n'est pas connecté, ce code renvoie sur le formulaire de connexion

if (! isConnected()) {
    // Affiche le formulaire de connexion et sort
    // Paramètre facultatif : $message
    $message = "Vous devez être connecté";
    require "index.php";
    exit;       // Fin du controleur
}