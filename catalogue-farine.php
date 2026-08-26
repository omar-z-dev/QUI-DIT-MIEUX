<?php

//role : afficher le catalogue de farine via l'api
//param : neant

// Initialisations diverses
$api = new api();

//recuperer le catalogue de farine
$catalogueFarines = $api->getCatalogueFarineByCurl();


header("Content-Type: application/json");

//envoyer le catalogue de farine (json)
echo json_encode($catalogueFarines);

exit;