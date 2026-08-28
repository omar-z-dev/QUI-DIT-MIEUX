<?php

/*

Rôle : gérer l'authentification et l'inscription des utilisateurs

Paramètres : action (login ou register) et les données du formulaire (identifiant, mot de passe, pseudo, email)

*/

require_once "libr/init.php";

// Récupération du paramètre action pour différencier entre login ou register
$action = $_GET["action"] ?? "";

switch ($action) {

    /*================================
                CONNEXION
    ================================*/
    case "login":

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            // Si on arrive en POST, Récupérer les données du formulaire
            $identifiant = trim($_POST["identifiant"] ?? "");
            $password    = trim($_POST["password"] ?? "");

            // A-t-on saisi les codes de connexion ?
            if (empty($identifiant) || empty($password)) {
                $_SESSION["error_login"] = "Tous les champs sont obligatoires ❌";
                header("Location: auth.php?action=login");
                exit;
            }

        //instancier un utilisateur
        $utilisateur = new utilisateur();

        //verifier si l'utilisateur existe ds la BDD (utilisation de la methode login)
        $verifuser = $utilisateur->login($identifiant, $password);

        if ($verifuser){

            //créer la session pour stocker les info de l'utilisateur dans $_SESSION
            //var_dump($user);  exit;
            connection($utilisateur);

            //rediriger vers dashboard
            header("Location: dashboard.php");
            exit;
        }
            //message d'erreur a afficher sur la page d'accueil
            $_SESSION["error_login"] = "😱 Identifiant de connexion et/ou mot de passe incorrect";
            header("Location: auth.php?action=login");
            exit;
        }
          // Si on arrive en GET, afficher le formulaire
            require "templates/pages/afficher-page-connexion.php";
            break;

    /*================================
         CRÉATION DU COMPTE
    ================================*/
    case "register":

        if ($_SERVER["REQUEST_METHOD"] === "POST") {

            // Si on arrive en POST, Récupérer les données du formulaire
            $pseudo   = trim($_POST["pseudo"] ?? "");
            $email    = trim($_POST["email"] ?? "");
            $password = $_POST["password"] ?? "";


            // traitement de l'inscription 
            $utilisateur = new utilisateur();

            // verifier si tous les champs sont remplis
            if (empty($pseudo) || empty($email) || empty($password)) {
                $_SESSION["error_register"] = "Tous les champs sont obligatoires ❌";
                header("Location: auth.php?action=register");
                exit;
            }

            //verifier si email valide avec la fonction filter_var

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                $_SESSION["error_register"] = "Email invalide ❌";

                header("Location: auth.php?action=register");
                exit;
            }

            //verifier pseudo valide avec expression régulière (regex)
            if (!preg_match("/^[a-zA-ZÀ-ÿ -]{2,50}$/", $pseudo)) {

                $_SESSION["error_register"] = "pseudo invalide ❌";

                header("Location: auth.php?action=register");
                exit;
            }

            //verifier si email est unique
            if ($utilisateur->findBy("email", $email)) {

                $_SESSION["error_register"] = "Cet email existe déjà ❌";

                header("Location: auth.php?action=register");
                exit;
            }

            //*******!recaptchat 

            $recaptcha = new recaptcha();

            /*Quand l'utilisateur coche le reCAPTCHA Google génère un jeton temporaire (token). Le navigateur l'envoie avec le formulaire  , puis on récupère le jeton de l'utilisateur.*/
            $token = $_POST["g-recaptcha-response"] ?? "";
            

            if (!$recaptcha->verify($token)) {

                $_SESSION["error_recaptcha"] = "Veuillez valider le reCAPTCHA";
                header("Location: auth.php?action=register");
                exit;
            }

            //assigner les parametre de l'utilisateur
            $utilisateur->set("pseudo", $pseudo);
            $utilisateur->set("email", $email);
            $utilisateur->set("mdp", $password);

            $userRegister = $utilisateur->register();

            if ($userRegister){

                //message de confirmation de creation de compte
                $_SESSION["success_register"] = "✅ Compte créé avec succes";
                header("Location: auth.php?action=login");
                exit;
            
            }
                //message d'erreur création compte
                $_SESSION["error_register"] = "😱 Erreur création compte";
                header("Location: auth.php?action=register");
                exit;
        }
           
        // Si on arrive en GET : afficher le formulaire
        require "templates/pages/afficher-page-inscription.php";
        break;

    default:

        header("Location: index.php");
        exit;
}