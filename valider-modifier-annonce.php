<?php

/*

CONTROLEUR :
Rôle : valider la modification d'une annonce

Paramètres POST :
- annonce_id
- titre
- categorie
- description
- etat
- prix_depart
- date_fin
- photos[]

*/

// Initialisation
require_once "libr/init.php";

// Connexion requise
require "libr/require_login.php";

// Récupérer les données du formulaire
$annonceId  = $_POST["annonce_id"] ?? 0;
$titre      = trim($_POST["titre"] ?? "");
$categorie  = $_POST["categorie"] ?? "";
$description= trim($_POST["description"] ?? "");
$etat       = $_POST["etat"] ?? "";
$prixDepart = $_POST["prix_depart"] ?? "";
$dateFin    = $_POST["date_fin"] ?? "";

// Charger l'annonce
$annonce=new annonce();
// Charger l'annonce existante à modifier
$annonce->load($annonceId);

// Vérifier les champs obligatoires
if (
empty($titre) || 
empty($categorie) || 
empty($description) || 
empty($etat) || 
empty($prixDepart) || 
empty($dateFin)) {
    $_SESSION["error_annonce"]="Veuillez remplir tous les champs obligatoires.";
    header("Location: modifier-annonce.php?id=".$annonceId);
    exit;
}

// Remplir l'objet annonce avec les nouvelles valeurs
$annonce->set("titre",$titre);
$annonce->set("categorie",$categorie);
$annonce->set("description",$description);
$annonce->set("etat",$etat);
$annonce->set("prix_depart",$prixDepart);
$annonce->set("date_fin",$dateFin);

// Mettre à jour l'annonce dans la base de données
$annonce->update();


// AJOUT DES NOUVELLES PHOTOS

// Vérifier si l'annonce possède déjà une photo principale
$photo = new photo();

$photoPrincipale=$photo->getPhotoPrincipale($annonceId);

// Vérifier si l'utilisateur a sélectionné des photos
if (isset($_FILES["photos"]) && !empty($_FILES["photos"]["name"][0])) {

    // Parcourir chaque photo sélectionnée
    foreach ($_FILES["photos"]["name"] as $index=>$nomOriginal) {

        // Vérifier qu'il n'y a pas d'erreur d'upload
        if ($_FILES["photos"]["error"][$index]!==UPLOAD_ERR_OK) {
            continue;
        }

        // Récupérer le fichier temporaire
        $fichierTemporaire=$_FILES["photos"]["tmp_name"][$index];

        // Récupérer l'extension du fichier
        $extension=strtolower(pathinfo($nomOriginal,PATHINFO_EXTENSION));

        // Définir les extensions autorisées
        $extensionsAutorisees=["jpg","jpeg","png","webp"];

        // Ignorer les fichiers avec une extension non autorisée
        if (!in_array($extension,$extensionsAutorisees)) {
            continue;
        }

        // Créer un nom unique pour éviter les doublons
        $nomFichier=uniqid("annonce_").".".$extension;

        // Définir le dossier de destination
        $destination="img/".$nomFichier;

        // Déplacer la photo vers le dossier img
        if (move_uploaded_file($fichierTemporaire,$destination)) {

            // Créer un objet photo
            $photo=new photo();

            // Associer la photo à l'annonce
            $photo->set("annonce_id",$annonceId);
            // Enregistrer le nom du fichier
            $photo->set("fichier",$nomFichier);

            // S'il n'y a aucune photo principale,
            // la première nouvelle photo devient principale
            if(!$photoPrincipale){
                $photo->set("principale",1);

                // il existe une photo principale
                $photoPrincipale=true;
            }else{
                $photo->set("principale",0);
            }
            // Enregistrer la photo dans la base de données
            $photo->insert();
        }
    }
}

// Message de confirmation
$_SESSION["annonce"]="Annonce modifiée avec succès ✅";

// Retour au dashboard
header("Location: dashboard.php");
exit;