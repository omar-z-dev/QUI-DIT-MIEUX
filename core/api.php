<?php


require_once __DIR__ . "/../core/model.php";

class api extends _model{

    private string $urlCatalogue = "https://api.mywebecom.ovh/play/qdm/categ.php";

  /*=================================================
       1-            getCategoryByCurl
    ==================================================*/
    function getCategoryByCurl(){
        //role : recuprer le catalogue des categories via l'api
        //parametres : neant
        //retour : retourne le catalogue des categories

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

        /* object(stdClass)#1 (3) {
            ["1"]=>
            string(7) "Voiture"
            ["2"]=>
            string(6) "Maison"
            ["3"]=>
            string(12) "Informatique"
        }*/
    }

    /*=================================================
       2-            rechercherCategories
    ==================================================*/
    public function rechercherCategories($recherche){

        //role : recuprer les categories via l'api
        //parametres : $recherche
        //retour : retourne le catalogue des categories en tableau assoc

        //urlencode transforme le texte pour pouvoir le mettre dans une URL, voiture rouge devient voiture+rouge
        $url = $this->urlCatalogue . "?search=" . urlencode($recherche);

        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        
        //Retourner un tableau associatif  ex : 
           /* [
                "1" => "Voiture",
                "5" => "Voiture électrique",
                "8" => "Voiture ancienne"
            ]*/

        return json_decode($response, true);
    }
}