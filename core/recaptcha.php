<?php

class recaptcha {

    //cette variable est accessible uniquement à l'intérieur de la classe.

    /*la clé secrète ne doit jamais être accessible depuis :

        un contrôleur ;
        une autre classe ;
        un utilisateur ;
        le navigateur.*/

        
    // clé a google  : Je suis bien le propriétaire de ce site, autorise-moi à vérifier ce token
    private $secret = "6LeudFAtAAAAAJ8-gVHyYLV1mBTrUrDyBZragxa4";

    function verify($token) {


        $url = "https://www.google.com/recaptcha/api/siteverify";


        // Initialisation de l'API en donnant son URL
        $curl = curl_init($url);

        // On indique que c'est une requête de type POST
        curl_setopt($curl, CURLOPT_POST, true);

        // On indique que l'on veut récupérer directement les données envoyées par l'API
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);


        // On prépare le tableau des champs à envoyer à l'API
        $data = [
            "secret"   => $this->secret,
            "response" => $token
        ];
         
        // On donne ce tableau de champ à la librairie
        curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($data));

        
        // On soumet la requête et on récupère le résultat (false en cas d'échec)
        $result = curl_exec($curl);

        /*echo "<pre>";
        var_dump($result);
        echo "</pre>";
        exit;*/


        if ($result === false) {
            return false;
        }

        // On décode la réponse Json car on aura par exemple
        /*
        
        string(108) "{
                        "success"      : true,
                        "challenge_ts" : "2026-07-16T13:13:41Z",
                        "hostname"     : "fep-omar.play.mywebecom.ovh"
                        }"     */



        $response = json_decode($result);

        /*var_dump($response);
        echo "</pre>";
        exit;


        object(stdClass)#5 (3) {
                ["success"]=>bool(true)
                ["challenge_ts"]=>string(20) "2026-07-16T13:15:26Z"
                ["hostname"]=>string(27) "fep-omar.play.mywebecom.ovh"
        }*/


        //retourner le resulatat de la requête

        return $response->success ?? false;
    }
}