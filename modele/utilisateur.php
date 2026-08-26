<?php
/*
Classe utilisateur : gestion des objets utilisateur du MCD
*/

require_once __DIR__ . "/../core/model.php";

// Configuration de la classe enfant
class utilisateur extends _model {

    protected $table  = "utilisateurs";
    protected $fields = [
    "email" ,
    "mdp", 
    "pseudo",
    "date_creation"
    ];
    protected $links  = [];

/*=====================================================
      1.     authentifier un utilisateur
=======================================================*/
    function login($identifiant, $password) {
        // Rôle de la méthode: authentifier un utilisateur (verifier si l utilisateur existe ds la BDD)
        // Paramètres : $email, $password
        // Retour : true ou false  

        // Création de la requête
        $sql = "SELECT * FROM `$this->table` 
                where ( `email` = :identifiant OR  `pseudo` = :identifiant ) ";
                
        // Valoriser l'identifiant, ds ce cas l'email

        $param = [
            ":identifiant" => $identifiant,
        ]; 

        global $bdd;
        $req = $bdd->prepare($sql);
        // On vérifie que $req n'est pas false (si c'st false on arrête)
        if (!$req) {    // équivalent à if ($req != true)    cad if ($req == false)
            // Eventuellement message d'erreur (en debug seulement)
            return false;
        }
        if (!$req->execute($param)) {
            // Eventuellement message d'erreur (en debug seulement)
            echo $sql;
            return false;
        }
        //recuperer l'utilisateur en objet sans passer par tableau
        $user = $req->fetch(PDO::FETCH_ASSOC);
        
        //si l'utilisateur n'existe pas return false , stop la fonction
        if (!$user) {
            return false;
        }
        //verifier le mot de passe si ca match avec celui de la BDD

        if (!password_verify($password,  $user["mdp"])) {
            return false;
        }
        //remplir l'objet $user :
        $this->loadFromtab($user);
        return true;
    }

/*=====================================================
      2.     register un utilisateur
=======================================================*/
    function register(){
        // Rôle de la méthode: register un utilisateur
        // Paramètres : neant
        // Retour : true ou false

        // 1.hash du mot de passe avant insertion

        // 2.la methode value($nom) (utilisée ci dessous) decrite ds la classe _model permet de recuperer la valeur physique, le tableau values [] est rempli auparavant par le  : $this->set("mdp", email) du controleur login-register;

        $this->set("mdp", password_hash($this->value("mdp"), PASSWORD_DEFAULT));

        // OBJET ACTUEL : insertion en base avec la methode insert() decrite ds la classe _model

        //Info : la methode ParamsForSql() recupere [
            //":email" => "a@mail.com",
            //":mdp" => "$2y$10$...",

        return $this->insert();
    }

/*=====================================================
      3.     recup l'objet utilsateur par son nom
=======================================================*/
    function findBy($field, $value) {

        $sql = "SELECT * FROM `$this->table`
                WHERE $field = :value";

        $req = $this->execute($sql, [
            ":value" => $value
        ]);
        // A-t-on récupéré un ligne
        
        $lignes = $req->fetchAll(PDO::FETCH_ASSOC);
        if (empty($lignes)) return false;

        // Transférer le résultat (tableau) dans les attribut $this->values et $this->id
        $this->loadFromtab($lignes[0]);

        return $this->is();
    }
}

























// Utilisation
/*$user = new utilisateur();

$user->set('nom', 'Jean Dupont');
$user->set('email', 'jean@example.com');
$user->set('age', 32);
$user->set('ville', 'Paris');
$user->set('pays', 'France');

// À la fin, $values contient :
print_r($user->values);

// Résultat :
Array
(
    [nom] => Jean Dupont
    [email] => jean@example.com
    [age] => 32
    [ville] => Paris
)*/