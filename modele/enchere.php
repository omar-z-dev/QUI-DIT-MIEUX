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
      1.     
    =======================================================*/
}