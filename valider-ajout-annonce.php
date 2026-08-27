<?php
/*

Rôle : valider l'ajout d'une annonce et photos dans la BDD de l'utilisateur connecté 

Paramètre : les données du formulaire (titre, categorie, description, etat, prix_depart, date_fin et photo)

*/

require_once "libr/init.php";

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
    $_SESSION["error_annonce"] = "Tous les champs sont obligatoires ❌";

    header("Location: ajouter.php");
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
$annonce->set("date_creation", date("Y-m-d H:i:s"));
$annonce->set("utilisateur_id", $_SESSION["id"]);

// Insérer l'annonce
$resultat = $annonce->insert();

// Si l'annonce n'a pas été créée
if (!$resultat) {

    $_SESSION["error_annonce"] = "Erreur lors de la création de l'annonce ❌";

    header("Location: ajouter.php");
    exit;
}


//Récup id de l'Annonce
$annonceId = $annonce->id();

//TRAITER LA PHOTO

if (
    //Si l'utilisateur a ajouté une photo et qu'elle n'a pas eu d'erreur
    isset($_FILES["photo"]) &&
    $_FILES["photo"]["error"] === UPLOAD_ERR_OK
) {

    // Nom d'origine
    $nomOriginal = $_FILES["photo"]["name"];

    // Fichier temporaire créé par PHP
    $fichierTemporaire = $_FILES["photo"]["tmp_name"];

    // Récupérer l'extension de la photo
    $extension = strtolower(pathinfo($nomOriginal, PATHINFO_EXTENSION));

    // Extensions autorisées
    $extensionsAutorisees = ["jpg", "jpeg", "png", "webp"];

    if (!in_array($extension, $extensionsAutorisees)) {
        $_SESSION["error_annonce"] = "Format d'image non autorisé ❌";
        header("Location: ajouter.php");
        exit;
    }

    // Créer un nom unique
    $nomFichier = uniqid("annonce_") . "." . $extension;

    // Dossier dans lequel stocker les images
    $destination = "img/" . $nomFichier;

    /*var_dump($_FILES);
    exit;*/

    // Déplacer la photo
    if (move_uploaded_file($fichierTemporaire, $destination)) {
 
        // INSÉRER LA PHOTO DANS LA BDD
        $photo = new photo();

        $photo->set("annonce_id", $annonceId);
        $photo->set("fichier", $nomFichier);
        $photo->set("principale", 1);
-
        $photo->insert();
    }
}
// SUCCÈS
$_SESSION["success_annonce"] = "✅ Annonce créée avec succès";

header("Location: dashboard.php");
exit;

/* if ($resultat) {

    $_SESSION["success_annonce"] = "✅ Annonce créée avec succès";

    header("Location: dashboard.php");
    exit;
}

// Erreur
$_SESSION["error_annonce"] = "Erreur lors de la création de l'annonce ❌";

header("Location: ajouter.php");
exit;*/