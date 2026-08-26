<?php 

/*=====================================================
 1              initialiser connection
=======================================================*/

function sessionInit() {
    // Rôle : initialiser les infprmations de session
    // Paramètres : néant
    // Retour : true si on est connecté, false sinon

    // But : l'appeler à chaque début de controleur : idéalement dans init.php (relativement au debut, mais il faut charger la libraire avant)

    // Lancer le système de session :
      if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Vérifier si on est connect
    // Si oui : charger l'objet correspondant
    //   vérifier qu'il existe / est actif : si non, on force la déconnexion

    //Expiration automatique de session

//durée max sans activité en seconde
$timeout = 2000;

// vérifier si activité précédente existe
if (isset($_SESSION["last"])) {

        // temps écoulé
        $inactiveTime = time() - $_SESSION["last"];

        // si > .........
        if ($inactiveTime > $timeout) {
            // vider le tableau $_SESSION en mémoire avec  session_unset()
            deconnect();

            header("Location: accueil.php?timeout=1");
            exit;
        }
}
// mettre à jour le dernier temps d'activité
 $_SESSION["last"] = time();
 
}
/*=====================================================
   2            Fonction de connection
=======================================================*/

    function connection($user) {
        //role: enregistrer l'utilisateur connecté dans la session
        //parametres: $user
        //retour: néant

        $_SESSION["id"]        = $user->id();   
        $_SESSION["connected"] = true;
        $_SESSION["last"]      = time();
        $_SESSION["role"]      = $user->value("role");
    }

/*=====================================================
  3             Fonction de déconnection
=======================================================*/
function deconnect(){
    //Role : ferme la connection
    //parametres: neant
    //retour: neant
    $_SESSION = [];
    session_destroy(); 
} 
/*=====================================================
 4              vérifier connection
=======================================================*/

function isConnected() {
    //role: verifier si l'utilisateur est connecté
    //parametres: neant
    //retour: true ou false
    return !empty($_SESSION["id"]);
}
/*=====================================================
  5             recup user connecté 
=======================================================*/
function userConnected() {
    //role: recuperer l'utilisateur connecté
    //parametres: neant
    //retour: retourne l'objet correspondant à l'utilisateur connecté

    if (empty($_SESSION["id"])) {
        return false;
    } else {
        $user = new utilisateur();
        $user->load($_SESSION["id"]);
        return $user;
    }
}