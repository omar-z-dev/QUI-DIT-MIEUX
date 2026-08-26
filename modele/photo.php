<?php

require_once __DIR__ . "/../core/model.php";

class photo extends _model {

    protected $table = "photo";

    protected $fields = [
        "id",
        "annonce_id",
        "fichier",
        "principale"
    ];

    protected $links = [
        "annonce_id" => "annonce"
    ];

    /*=====================================================
      1.     
    =======================================================*/
}