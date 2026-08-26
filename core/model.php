<?php

/*
Classe générique "modèle" permettan de gérer un objet quelconque du MCD

glossaire :

methode is()  : ligne 53
methode id()  : ligne 64
methode set() : ligne 75
methode get() : ligne 92
methode getLink() : ligne 110
methode value()   : ligne 136
methode html()    : ligne 164
methode load()    : ligne 188
methode insert()  : ligne 217
methode update(   : ligne 246
methode delete()  : ligne 272
methode listAll() : ligne 293
methode findBy()      : ligne 321
methode loadFromtab() : ligne 334
methode execute()     : ligne 356
methode listFieldsForSql() : ligne 377
methode setFieldsForSql()  : ligne 389
methode paramForSql()      : ligne 410
methode fieldsForInsert()  : ligne 435
methode paramsForInsert()  : ligne 442
*/

class _model {

    // dérire le modèle conceptuel
    protected $table  = "";
    protected $fields = [];     // tableau des noms des champs du modèle conceptuel
    protected $links  = [];      // tableau avec nomdDuChamp => nom de l'objet pointé 
    //c’est une sorte de “configuration”.
    //ex :  "user_id" => "utilisateur" 
    //a utiliser par exemple : $nom = $this->links["user_id"];
    //revient a $nom = "utilisateur";
    //et peut etre utilise en new $nom(); qui revient a new utilisateur();


    // valeurs et infos internes
    protected $id = null;       // valeur de la clé primaire
    protected $values = [];    // valeurs des autres colonnes [ nomChamp => valeur, ....]
    protected $linkedObjects = [];      // Les objets liés : [ nomChamp => objet ]

    //!PROTECTED : Accessible uniquement :
        //dans la classe elle-même
        //dans les classes qui héritent

    /*=====================================================
                        Methode is() 
    =======================================================*/
    function is() {
        // Rôle : l'objet existe-il (est-il dans la BDD)
        // Paramètre : néant
        // Retour : true si il existe, false sinon

        return !empty($this->id);
    }
    /*=====================================================
                        Methode id() 
    =======================================================*/

    function id() {
        // Rôle : récupérer la valeur de l'id
        // Paramètres : néant
        // Retour : la valeur de l'id

        return $this->id;
    }
    // !getters et des setters
    /*=====================================================
                 Methode set($nom, $valeur) 
    =======================================================*/
    function set($nom, $valeur) {
        // Rôle : donner une valeur à l'attribut $nom
        // Paramètres : 
        //      $nom : nom de l'attribut
        //      $valeur : valeur à lui donner
        // Retour : true si réussi, false sinon

        // On s'assure que l'on a un champ (que $nom est bien un champ)
        if ( ! in_array($nom, $this->fields)) return false;

        // Mémoriser la valeur : clé => valeur
        $this->values[$nom] = $valeur;  
    }
    /*=====================================================
                        Methode get($nom) 
    =======================================================*/
    function get($nom) {
        // Rôle : récupérer l'atribut $nom (valeur dans le modèle conceptuel : pour un champ correspondant à un lien, on récupère l'objet pointé)
        // Paramètres : 
        //      $nom : nom de l'atrribut
        // Retour : l'attribut (valeur directe ou objet) ou ull si inexistant

        // Si le champ n'existe pas : erreur
        if ( ! in_array($nom, $this->fields)) return null;

        // Le champ existe : si c'est un lien, on va retourner l'objet lié
        if (isset($this->links[$nom])) return $this->getLink($nom);

        // Le champ existe et n'est pas un lien : on le retourne tel quel (null si il n'a pas de valeur
        if (isset($this->values[$nom])) return $this->values[$nom];
        else return null;
    }
    /*=====================================================
                        Methode getLink($nom) 
    =======================================================*/
    function getLink($nom) {
        // Rôle : récupérer l'objet pointé par le champ $nom
        //!👉 Elle sert à transformer un ID (ex: 7) en objet complet (Utilisateur).
        // Paramètres : 
        //      $nom : nom de l'atrribut
        // Retour : l'objet pointé, si ce n'est pas un lien, on retourn un objet de la classe _model
        
        // Si le champ (verifier si la clé existe ds le ta tableau $links declaré comme proprieté ds la classe courante) n'est pas un lien on abandonne :
        if ( ! isset($this->links[$nom])) return new _model();

        // est-til déjà stocké ? si oui on le reutilise sans faire de requête SQL
        if (isset($this->linkedObjects[$nom])) return $this->linkedObjects[$nom];

        $nomObjetPointe = $this->links[$nom];
        $objet = new $nomObjetPointe();
        
        //recuperer l'ID (avec $this->values[$nom]) et le charger avec la methode load
        if (isset($this->values[$nom])) $objet->load($this->values[$nom]);

        // Mémoriser l'objet chargé (objet utilisateur chargé depuis la BDD)
        $this->linkedObjects[$nom] = $objet;
        return $objet;
    }
    /*=====================================================
                        Methode value($nom) 
    =======================================================*/
    function value($nom) {
            // Rôle : récupérer la valeur physqiue (donc l'id pour les objets liés) de l'attribut $nom
            //      $nom : nom de l'atrribut
            // Retour : l'attribut (valeur directe)

            //Elle ne regarde PAS $links.
            //Elle ne crée aucun objet.
            //Elle ne charge pas la BDD.

        // le champ existe il (nom de colonne biensur)
        if (!in_array($nom, $this->fields)) {
            return null;
        }

        // retourner valeur physique

        //"La clé $nom existe-t-elle dans le tableau  et valeur pas nulle ?"
        if (isset($this->values[$nom])) {

            // Si oui, on retourne la valeur
            return $this->values[$nom];
        }

        return null;
    }
    /*=====================================================
                        Methode html($nom)
    =======================================================*/
    function html($nom) {
            // Rôle : récupérer la valeur html l'attribut $nom (qui n'est pas un lien)
            //      $nom : nom de l'atrribut
            // Retour : l'attribut encodé en HTML

            // Si c'est un attribut "simple : on se contente d'encoder en html la valeur
            // Si c'est un objet : il faudrait aler cherche son nom (donc poir l'instant on ne fera rien)
                // récupérer la valeur brute
        $valeur = $this->value($nom);

        // si null → retourner vide
        if ($valeur === null) {
            return "";
        }
        // sécuriser pour HTML
        return htmlspecialchars($valeur); 
    }

    // Méthodes pour "sychroniser" avec la BDD : 

    /*=====================================================
      1.                  load 
    =======================================================*/

    function load($id) {
        // Rôle : chargement de l'objet courant depuis la BDD, ave le ligne de clé primaire $id
        // Paramètres :
        //      $id : valeur de l'id cherché
        // retour : true si réussi, false sinon

        // Remise à zéro l'objet
        $this->id = 0;
        $this->values = [];
        $this->linkedObjects = [];

        // Passer une requête sur la BDD pour récupérer la ligne
        // Requête sql
        $sql = "SELECT " . $this->listFieldsForSql() . " FROM `$this->table` WHERE `id` = :id";
        $req = $this->execute($sql, [ ":id" => $id]);

        // A-t-on récupéré un ligne .
        $lignes = $req->fetchAll(PDO::FETCH_ASSOC);
        if (empty($lignes)) return false;

        // Transférer le résultat (tableau) dans les attribut $this->values et $this->id
        $this->loadFromtab($lignes[0]);

        return $this->is();
    }

    /*=====================================================
      1.2                __construct 
    =======================================================*/

    function __construct($id = null) {

        if ($id !== null) {

            $this->load($id);
        }
    }

    /*=====================================================
      2.                  insert 
    =======================================================*/
    function insert() {
        // Rôle : insérer l'objet courant dans la BDD
        // Paramètres : néant
        // Retour : true si réussi, false sinon

        //construire la requete SQL en utilsantles fonction utiles crées :
        $sql = "INSERT INTO `{$this->table}` (" . $this->fieldsForInsert() . ") 
            VALUES (" . $this->paramsForInsert() . ")";


        // 1--fieldsForInsert() retourne par exemple : "`titre`,`description`,`montant`"

        // 2--paramsForInsert() retourne par exemple: ":titre,:description,:montant"

        // 3--paramForSql() retourne par exemple: [ ":titre" => "titre", ":description" => "description", ":montant" => "montant" ]

    
        // Récupérer les paramètres (méthode paramForSql)
        $params = $this->paramForSql();

        global $bdd;
        
        // Exécuter la requête
        $req = $this->execute($sql, $params);
        
        // Vérifier si l'exécution a réussi
        if ($req === false) {
            return false;
        }
        $this->id = $bdd->lastInsertId();
        return true;
    }

    /*function lastInsertId() {
        global $bdd;
        return $bdd->lastInsertId();
    }*/
    /*=====================================================
      3.                 update 
    =======================================================*/
    function update() {
        // Rôle : met à jour de la ligne correspondant à l'objet courant dans la BDD
        // Paramètres : néant
        // Retour : true si réussi, false sinon

        // Construction de la requête UPDATE
        // Utilisation de setFieldsForSql() pour générer la partie SET
        $sql = "UPDATE `{$this->table}` " . $this->setFieldsForSql() . " WHERE `id` = :id";

        // Récupération des paramètres
        $params = $this->paramForSql();
        // Ajout de l'id pour la condition WHERE
        $params[':id'] = $this->id;

        // Exécution de la requête
        $req = $this->execute($sql, $params);
        
        // Retourne true si la requête a réussi, false sinon
        if ($req === false) {
            return false;
        }
        return true;
    }
    /*=====================================================
      4.                  delete 
    =======================================================*/
    function delete() {
        // Rôle : supprime l'enregistrement correspondant à l'objet courant dans la BDD
        // Paramètres : néant
        // Retour : true si réussi, false sinon

        // Construction de la requête DELETE
        $sql = "DELETE FROM `{$this->table}` WHERE `id` = :id";
        
        // Exécution :
        $req = $this->execute($sql, [':id' => $this->id]);
        
        // Vérifier si la suppression a réussi
        if ($req === false) {
            return false;
        }        
        return true;
    }

    /*=====================================================
      5.                 listAll 
    =======================================================*/
    function listAll() {
        // Rôle : lister tous les enregistrements de la table
        // Paramètres : néant
        // Retour : tableau d'objets 
        $sql = "SELECT " . $this->listFieldsForSql() . " FROM `$this->table`";

        $req = $this->execute($sql);

        $lignes = $req->fetchAll(PDO::FETCH_ASSOC);
        $objets = [];
        
        // get_class($this) retourne nom de la classe de l'objet courant (ex : "Projet" ou "Utilisateur")
        $className = get_class($this);
        
        foreach ($lignes as $ligne) {
            // Créer un nouvel objet de la même classe que l'objet courant, le charger avec la ligne, et le stocker dans le tableau des objets
            $objet = new $className();
            $objet->loadFromtab($ligne);
            $objets[] = $objet;
        }
        return $objets;
    }

    /*===================================================================
    //                                                                  //
    //                todo : METHODES UTILES                              //
    //                                                                  //
    ====================================================================*/
    function findBy($champ, $valeur) {

        $sql = "SELECT id 
                FROM `$this->table`
                WHERE `$champ` = :valeur";

        $req = $this->execute($sql, [
            ":valeur" => $valeur
        ]);

        return $req->fetch(PDO::FETCH_ASSOC);
    }

    function loadFromtab($tableau) {
        // Rôle : charger l'objet courant (ses attributs) depuis un tableau indexé
        // Paramètres :
        //      $tableau : tabelau contenant les noms des attributs en index et les valeurs en valeur
        // Retour : true si  réussi, false sinon

        // Pour chaque attribut de l'objet (or id)
        foreach($this->fields as $nomChamp) {
            // Si il existe dans le tableau
            if (isset($tableau[$nomChamp])) {
                // On met à jour la valeur
                $this->set($nomChamp, $tableau[$nomChamp]);
            }
        }

        // ON accepte l'id que si il n'est pas déjà existant
        if (empty($this->id) and isset($tableau["id"])) {
            $this->id = $tableau["id"];
        }
        return true;
    }

    function execute($sql, $param = []) {
        // Rôle : exécuter une requête et retourner l'objet requete exécutée
        // Paramètres : 
        //      $sql : texte de la requête SQL, ave des paramètres :xxx
        //      $param : tabelau donnant la valeur des paramètres :xxx
        // Retour : objet requête exécutée, ou false en cas d'erreur

        global $bdd;

        // Préparer une requête
        $req = $bdd->prepare($sql);
        if ($req == false) {
            return false;
        }
        if ( ! $req->execute($param)) {
            return false;
        }

        return $req;
    }

    function listFieldsForSql() {
        // Rôle : retourner la chaine SQL avec la liste des champs de cet objet
        // PAamètres : néant
        // Rerour : texte (champs séparés par ,)

        $sql = "`id`";
        // POur chaque champ, l'ajouter au texte (avec les ` et la , devant)
        foreach ($this->fields as $nomChamp) $sql .= ",`$nomChamp`";

        return $sql;
    }
            /****** fonction pour UPDATE avec set *********/
    function setFieldsForSql() {
        // Rôle : construit la chaine SQL : SET nomChamp1 = :nomChamp1, nomChamp2 = :nomChamp2 ...
        // Paramètres : néant (on prend tous les champs de l'objet)
        // Retour : la chaine

        $tab = [];
        foreach($this->fields as $nom) $tab[] = "`$nom` = :$nom";

        return "SET " . implode(",", $tab);

    }

    /*function setFieldsForSql() {
    // !Génère : SET `nom` = :nom, `email` = :email, `age` = :age
    $tab = [];
    foreach($this->fields as $nom) {
        $tab[] = "`$nom` = :$nom";
    }
    return "SET " . implode(",", $tab);
    }*/

    function paramForSql() {
        // Rôle : construit le tableau des paramètres [ ":nomChamp1" => valeur1, .... ]
        // Paramètres : néant (on prend tous les champs de l'objet)
        // Retour : le tableau

        $tab = [];
        foreach($this->fields as $nom) {
            if (isset($this->values[$nom])) $tab[":$nom"] = $this->values[$nom];
            else $tab[":$nom"] = null;
        }
        return $tab;
    }

    /*function paramForSql() {
    // !Génère : [':nom' => 'Jean', ':email' => 'jean@mail.com', ':age' => 32]
    $tab = [];
    foreach($this->fields as $nom) {
        $tab[":$nom"] = $this->values[$nom] ?? null;
    }
    return $tab;
    }*/

          /***** Pour INSERT INTO -**************/

// pour INSERT (liste des champs sans l'id)
function fieldsForInsert() {
    // Retourne : "`titre`,`description`,`montant`" (sans l'id)
    if (empty($this->fields)) return "";
    return "`" . implode("`,`", $this->fields) . "`";
}

//pour INSERT (liste des paramètres)
function paramsForInsert() {
    // Retourne : ":titre,:description,:montant"
    if (empty($this->fields)) return "";
    return ":" . implode(",:", $this->fields);
}


}