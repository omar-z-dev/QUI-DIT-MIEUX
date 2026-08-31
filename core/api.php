<?php


require_once __DIR__ . "/../core/model.php";

class api extends _model{

    private string $urlCatalogue = "https://api.mywebecom.ovh/play/qdm/categ.php";


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
    }

    /*=================================================
       1-            rechercherCategories
    ==================================================*/
    public function rechercherCategories($recherche){
        //role : recuprer les categories via l'api
        //parametres : $recherche
        //retour : retourne le catalogue des categories
    $url = $this->urlCatalogue . "?search=" . urlencode($recherche);

    $curl = curl_init($url);

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($curl);
    
    //Tableau associatif 
    return json_decode($response, true);
}
}