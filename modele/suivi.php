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
      1.     
    =======================================================*/
}