<?php

/*

CONTROLEUR :
Rôle : valider et enregistrer les modifications du profil

Paramètres POST :
- pseudo : nouveau pseudo
- email : nouvel email
- mdp

*/

// Initialisation
require_once "libr/init.php";

// Connexion requise
require "libr/require_login.php";

// Récupérer les données du formulaire
$pseudo   = trim($_POST["pseudo"]?? "");
$email    = trim($_POST["email"]?? "");
$password = $_POST["password"]??"";


// Charger l'utilisateur connecté
$utilisateur = userConnected();


// Modifier le pseudo seulement s'il est saisi
if(!empty($pseudo)){
    $utilisateur->set("pseudo",$pseudo);
}

// Modifier l'email seulement s'il est saisi
if(!empty($email)){
    $utilisateur->set("email",$email);
}

// Modifier le mot de passe seulement s'il est saisi
if(!empty($password)){

    $passwordHash=password_hash($password, PASSWORD_DEFAULT );
    $utilisateur->set("password",$passwordHash);
}

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