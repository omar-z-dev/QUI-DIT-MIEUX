<?php
/*

CONTROLEUR :
Rôle : Enregistrer une annonce et photo(s) dans dans la BDD de l'utilisateur connecté 

Paramètre : les données du formulaire (titre, categorie, description, etat, prix_depart, date_fin et photo)

*/

// Initialisation
require_once "libr/init.php";

// Connexion requise
require "libr/require_login.php";

/*var_dump($_SESSION);
exit;*/

// Récupérer les données du formulaire
$titre        = trim($_POST["titre"] ?? "");
$categorie    = $_POST["categorie"] ?? "";
$description  = trim($_POST["description"] ?? "");
$etat         = $_POST["etat"] ?? "";
$prix_depart  = $_POST["prix_depart"] ?? "";
$date_fin     = $_POST["date_fin"] ?? "";

// Vérifier que tous les champs sont remplis
if (
    empty($titre) ||
    empty($categorie) ||
    empty($description) ||
    empty($etat) ||
    empty($prix_depart) ||
    empty($date_fin)
) {
    $_SESSION["error_annonce"] = "Veuillez renseigner tous les champs obligatoires. L'ajout de photos est facultatif. ❌";

    header("Location: ajouter-annonce.php");
    exit;
}

// Instancier un objet annonce
$annonce = new annonce();

// Remplir l'objet
$annonce->set("titre", $titre);
$annonce->set("categorie", $categorie);
$annonce->set("description", $description);
$annonce->set("etat", $etat);
$annonce->set("prix_depart", $prix_depart);
$annonce->set("date_fin", $date_fin);
$annonce->set("date_creation", date("Y-m-d H:i"));
$annonce->set("utilisateur_id", $_SESSION["id"]);

// Insérer l'annonce
$resultat = $annonce->insert();

// Si l'annonce n'a pas été créée
if (!$resultat) {

    $_SESSION["error_annonce"] = "Erreur lors de la création de l'annonce ❌";

    header("Location: ajouter-annonce.php");
    exit;
}

//Récup id de l'Annonce
$annonceId = $annonce->id();

//TRAITER LA PHOTO
// Vérifier si des photos ont été envoyées
if (isset($_FILES["photos"])) {
    /*$_FILES["photos"] = [

            "name" => [
                0 => "voiture.jpg",
                1 => "interieur.jpg",
                2 => "moteur.jpg"
            ],

            "tmp_name" => [
                0 => "/tmp/phpAAA",
                1 => "/tmp/phpBBB",
                2 => "/tmp/phpCCC"
            ],

            "error" => [
                0 => 0,
                1 => 0,
                2 => 0
            ]
        ];*/

    // Parcourir les photos car $_FILES["photos"] est un tableau de tableaux
    foreach ($_FILES["photos"]["name"] as $index => $nomOriginal) {

        // Vérifier cette photo
        if ($_FILES["photos"]["error"][$index] === UPLOAD_ERR_OK) {

            // Récupèrer l'emplacement temporaire où PHP a stocké la photo envoyée par l'utilisateur.
            $fichierTemporaire = $_FILES["photos"]["tmp_name"][$index];

            // Extension
            $extension = strtolower(
                pathinfo($nomOriginal, PATHINFO_EXTENSION)
            );

            // Extensions autorisées sinon ignorer
            $extensionsAutorisees = ["jpg", "jpeg", "png", "webp"];

            if (!in_array($extension, $extensionsAutorisees)) {
                continue;
            }

            // Création d'un nom unique pour eviter les doublons
            $nomFichier = uniqid("annonce_") . "." . $extension;

            // Destination
            $destination =  "img/" . $nomFichier;

            // Déplacer l'image temporaire vers la destination
            if (move_uploaded_file($fichierTemporaire, $destination)) {

                // Instancier un objet photo
                $photo = new photo();
                // Remplir l'objet photo
                $photo->set("annonce_id", $annonceId);
                $photo->set("fichier", $nomFichier);

                // Première photo = principale a afficher sur la page
                if ($index === 0) {
                    $photo->set("principale", 1);
                } else {
                    $photo->set("principale", 0);
                }
                // Insérer la photo dans la base
                $photo->insert();
            }
        }
    }
}
// SUCCÈS
$_SESSION["success_annonce"] = "✅ Annonce créée avec succès";
header("Location: dashboard.php");
exit;




