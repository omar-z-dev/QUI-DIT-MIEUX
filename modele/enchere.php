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
    /*=====================================================
      2.  getEncheresByAnnonce
    =======================================================*/
    public function getEncheresByUtilisateur($utilisateurId){

    // Rôle : recuperer les encheres d'un utilisateur
    // Parametre : $utilisateurId
    // Retour : tableau d'objets enchere
    $sql="SELECT *
          FROM `$this->table`
          WHERE utilisateur_id = :utilisateur_id
          ORDER BY montant DESC";

    $req=$this->execute($sql,[
        ":utilisateur_id"=>$utilisateurId
    ]);
    $resultats = $req->fetchAll(PDO::FETCH_ASSOC);
    $encheres = [];
    $className = get_class($this);

    foreach($resultats as $ligne){
        $objet = new $className();
        $objet->loadFromtab($ligne);
        $encheres[]=$objet;
    }

    return $encheres;
}
}