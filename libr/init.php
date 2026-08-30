<?php
/*

Role : initialiser l'application (BDD, session, autoload des modèles)
parametres : aucun

*/

// Lignes de code pour l'initialisation des contrôleurs
//heure paris 
date_default_timezone_set('Europe/Paris');

// gestion des erreurs
ini_set('display_errors',1);
error_reporting(E_ALL);

// Ouvrir la BDD (dans la variable globale $bdd)
global $bdd;        // déclarer la varianle $bdd comme globale
$bdd = new PDO("mysql:host=172.18.0.1;dbname=qdm-omar;charset=UTF8", "qdm-omar","T?59jpyytk");
$bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING) ;  // En mise au point seulement


/* ---------------- AUTLOAD MODELES ---------------- */

//!Si tu rencontres une classe inconnue, appelle la fonction loadModel($name)” : en faisant $user = new utilisateur(); PHP cherche la classe utilisateur Il ne la trouve pas encore .Donc il appelle automatiquement :loadModel("utilisateur");

function loadModel($name) {
    $file = __DIR__ . "/../modele/$name.php";

    if (file_exists($file)) {
        require_once $file;
    }
}

spl_autoload_register("loadModel");

/* ---------------- SESSION ---------------- */

require_once __DIR__ . "/../libr/session.php";
require_once __DIR__ . "/../core/recaptcha.php";
require_once __DIR__ . "/../core/api.php";

// Initialisation de la session en chargeant la fonction (presente ds session.php) qui inclut session_start

// crée / lit un fichier de session côté serveur
// associé à un ID de session (cookie PHPSESSID)
sessionInit();

