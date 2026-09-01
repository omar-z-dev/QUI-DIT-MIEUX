<?php

/*
CONTROLEUR :
Rôle : valider et enregistrer les modifications du profil

Paramètres POST :
- pseudo : nouveau pseudo
- email : nouvel email
*/

// Initialisation
require_once "libr/init.php";

// Connexion requise
require "libr/require_login.php";

// Récupérer les données du formulaire
$pseudo = trim($_POST["pseudo"]??"");
$email  = trim($_POST["email"]??"");

// Vérifier que les champs ne sont pas vides
if(empty($pseudo)||empty($email)){
    $_SESSION["error"] = "Le pseudo et l'email sont obligatoires.";

    header("Location: modifier-profil.php");
    exit;
}

// Charger l'utilisateur connecté
$utilisateur = userConnected();

// Modifier les informations
$utilisateur->set("pseudo",$pseudo);
$utilisateur->set("email",$email);

// Enregistrer les modifications
$resultat = $utilisateur->update();

// Vérifier le résultat
if($resultat){
    $_SESSION["success_profil"] = "Profil modifié avec succès ✅";
}else{
    $_SESSION["success_profil"] = "Erreur lors de la modification du profil ❌";
}

// Redirection
header("Location: dashboard.php");
exit;