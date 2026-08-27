<?php

require_once __DIR__ . "/../core/model.php";

class annonce extends _model {

    protected $table = "annonce";

    protected $fields = [
        "id",
        "titre",
        "categorie",
        "description",
        "etat",
        "prix_depart",
        "date_fin",
        "date_creation",
        "utilisateur_id"
    ];

    protected $links = [
        "utilisateur_id" => "utilisateur"
    ];

    /*=====================================================
      1.                 listAll by user
    =======================================================*/
    function listAllByUser($utilisateur_id) {
        // Rôle : lister tous les enregistrements de la table
        // Paramètres : néant
        // Retour : tableau d'objets 
        $sql = "SELECT " . $this->listFieldsForSql() . " FROM `$this->table` 
        WHERE utilisateur_id = :utilisateur_id";

        $req = $this->execute($sql, [
        ":utilisateur_id" => $utilisateur_id
        ]);

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
}