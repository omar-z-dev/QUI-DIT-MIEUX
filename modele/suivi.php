<?php

require_once __DIR__ . "/../core/model.php";

class suivi extends _model {

    protected $table = "suivi";

    protected $fields = [
        "id",
        "utilisateur_id",
        "annonce_id",
        "date_suivi"
    ];

    protected $links = [
        "utilisateur_id" => "utilisateur",
        "annonce_id" => "annonce"
    ];

    /*=====================================================
      1.     estSuivie
    =======================================================*/
    function estSuivie($utilisateurId, $annonceId){
        // Rôle : vérifier si un utilisateur suit déjà une annonce
        // Paramètres :
        //   $utilisateurId : id de l'utilisateur
        //   $annonceId : id de l'annonce
        // Retour :
        //   true si elle est déjà suivie
        //   false sinon

        $sql = "SELECT id
                FROM `$this->table`
                WHERE utilisateur_id = :utilisateur_id
                AND annonce_id = :annonce_id
                LIMIT 1";

        $req = $this->execute($sql, [
            ":utilisateur_id" => $utilisateurId,
            ":annonce_id" => $annonceId
        ]);

        $ligne = $req->fetch(PDO::FETCH_ASSOC);

        if ($ligne) {
            return true;
        } else {
            return false;
        }
    }
}