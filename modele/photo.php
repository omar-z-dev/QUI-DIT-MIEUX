<?php

require_once "core/model.php";

class photo extends _model {

    protected $table = "photo";

    protected $fields = [
        "annonce_id",
        "fichier",
        "principale"
    ];

    protected $links = [
        "annonce_id" => "annonce"
    ];

    /*=====================================================
      1.             getPhotoPrincipale
    =======================================================*/
    function getPhotoPrincipale($annonceId){
        // Rôle      : récupérer la photo principale d'une annonce
        // Paramètre : id de l'annonce
        // Retour    : objet photo ou false

        $sql = "SELECT *
                FROM `$this->table`
                WHERE annonce_id = :annonce_id
                AND principale = 1
                LIMIT 1";

        $req = $this->execute($sql, [
            ":annonce_id" => $annonceId
        ]);

        // Récupérer UNE ligne
        $ligne = $req->fetch(PDO::FETCH_ASSOC);

        if (!$ligne) {
            return false;
        }

        // Récupérer le nom de la classe actuelle : "photo"
        $className = get_class($this);

        // Créer un nouvel objet photo
        $objet = new $className();

        // Remplir l'objet avec les données récupérées
        $objet->loadFromtab($ligne);
        return $objet;
    }
    /*=====================================================
      2.            getPhotosByAnnonce
    =======================================================*/
    function getPhotosByAnnonce($annonceId){
        // Rôle      : récupérer toutes les photos d'une annonce
        // Paramètre : id de l'annonce
        // Retour    : tableau d'objets photo

        $sql = "SELECT *
                FROM `$this->table`
                WHERE annonce_id = :annonce_id";

        $req = $this->execute($sql, [
            ":annonce_id" => $annonceId
        ]);

        // Récupérer toutes les lignes
        $lignes = $req->fetchAll(PDO::FETCH_ASSOC);
        $objets  = [];
        $className = get_class($this);

        foreach ($lignes as $ligne) {
            $objet = new $className();
            $objet->loadFromtab($ligne);
            $objets[] = $objet;
        }
        return $objets;
    }
}