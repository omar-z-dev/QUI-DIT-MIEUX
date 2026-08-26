<?php

require_once __DIR__ . "/../core/model.php";

class annonce extends _model {

    protected $table = "annonce";

    protected $fields = [
        "id",
        "titre",
        "categorie_id",
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
      1.     
    =======================================================*/
}