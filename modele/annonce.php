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
        // Rôle       : lister tous les enregistrements de la table
        // Paramètres : néant
        // Retour     : tableau d'objets 
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

    /*=====================================================
      2.                 listAll by categorie
    =======================================================*/
    /*function rechercherAnnonces($texte, $categorie, $etat, $prix, $vente){
        $sql = "SELECT " . $this->listFieldsForSql() . "
                FROM `$this->table`
                WHERE 1=1";

        $params = [];

        // Texte dans titre OU description
        if ($texte !== "") {

            $sql .= " AND (
                        titre LIKE :texte
                        OR description LIKE :texte
                    )";

            $params[":texte"] = "%" . $texte . "%";
        }

        // Catégorie
        if ($categorie !== "") {

            $sql .= " AND categorie = :categorie";
            $params[":categorie"] = $categorie;
        }

        // État
        if ($etat !== "") {
            $sql .= " AND etat = :etat";
            $params[":etat"] = $etat;
        }

        // Prix maximum
        if ($prix !== "") {
            $sql .= " AND prix_depart <= :prix";
            $params[":prix"] = $prix;
        }

        // Vente en cours
        if ($vente === "en_cours") {
            $sql .= " AND date_fin > NOW()";
        }

        // Vente terminée
        if ($vente === "terminee") {
            $sql .= " AND date_fin <= NOW()";
        }

        $req = $this->execute($sql, $params);
        $lignes = $req->fetchAll(PDO::FETCH_ASSOC);
        $objets = [];

        foreach ($lignes as $ligne) {
            $objet = new annonce();
            $objet->loadFromtab($ligne);
            $objets[] = $objet;
        }
        return $objets;
    }*/

        /*=====================================================
      2.                 listAll by categorie
    =======================================================*/
    function listOtherAnnonces($utilisateurId){
        // Rôle      : récupérer toutes les annonces sauf celles
        // de l'utilisateur connecté
        // Paramètre : id utilisateur
        // Retour    : tableau d'objets annonce

        $sql = "SELECT " . $this->listFieldsForSql() . "
                FROM `$this->table`
                WHERE utilisateur_id != :utilisateur_id";

        $req = $this->execute($sql, [
            ":utilisateur_id" => $utilisateurId
        ]);

        $lignes = $req->fetchAll(PDO::FETCH_ASSOC);
        $objets = [];
        $className = get_class($this);

        foreach ($lignes as $ligne) {
            $objet = new $className();
            $objet->loadFromtab($ligne);
            $objets[] = $objet;
        }
        return $objets;
    }

}