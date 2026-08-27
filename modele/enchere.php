<?php

require_once __DIR__ . "/../core/model.php";

class enchere extends _model {

    protected $table = "enchere";

    protected $fields = [
        "id",
        "annonce_id",
        "utilisateur_id",
        "montant",
        "date_enchere"
    ];

    protected $links = [
        "annonce_id" => "annonce",
        "utilisateur_id" => "utilisateur"
    ];

    /*=====================================================
      1.  getMeilleureEnchere
    =======================================================*/
    function getMeilleureEnchere($annonceId){
        // Rôle : récupérer la meilleure enchère d'une annonce
        // Paramètre : id de l'annonce
        // Retour : objet enchere ou false
        $sql = "SELECT *
                FROM `$this->table`
                WHERE annonce_id = :annonce_id
                ORDER BY montant DESC
                LIMIT 1";

        $req = $this->execute($sql, [
            ":annonce_id" => $annonceId
        ]);

        $ligne = $req->fetch(PDO::FETCH_ASSOC);

        if (!$ligne) {
            return false;
        }

        $className = get_class($this);
        $objet = new $className();
        $objet->loadFromtab($ligne);
        return $objet;
    }
}