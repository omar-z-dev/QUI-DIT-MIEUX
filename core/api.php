<?php


require_once __DIR__ . "/../core/model.php";

class api extends _model{

    private string $urlCatalogue = "https://api.mywebecom.ovh/play/fep/catalogue.php";


    function getCatalogueFarineByCurl(){
        //role : recuprer le catalogue de farine via l'api
        //parametres : neant
        //retour : retourne le catalogue de farine
        
        // Initialisation cURL
        $curl = curl_init($this->urlCatalogue);

        // Récupérer la réponse
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        // Exécuter la requête
        $resultat = curl_exec($curl);


        // Vérifier les erreurs cURL
        if ($resultat === false) {

            throw new Exception(
                "Erreur cURL : " . curl_error($curl)
            );
        }

        // Transformer JSON en objet PHP
        return json_decode($resultat);
    }
}