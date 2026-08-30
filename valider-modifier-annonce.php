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

require_once "libr/init.php";

// Vérifier que l'utilisateur est connecté
if (empty($_SESSION["connected"])) {
    header("Location: auth.php?action=login");
    exit;
}

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

// Vérifier les champs obligatoires
if (
empty($titre) || 
empty($categorie) || 
empty($description) || 
empty($etat) || 
empty($prixDepart) || 
empty($dateFin)) {
    $_SESSION["error_annonce"]="Veuillez remplir tous les champs obligatoires.";
    header("Location: afficher-modifier-annonce.php?id=".$annonceId);
    exit;
}

// Mettre les nouvelles valeurs dans l'objet annonce
$annonce->set("titre",$titre);
$annonce->set("categorie",$categorie);
$annonce->set("description",$description);
$annonce->set("etat",$etat);
$annonce->set("prix_depart",$prixDepart);

// Transformer la date HTML en format MySQL
$dateFin=str_replace("T"," ",$dateFin);
$annonce->set("date_fin",$dateFin);

// Mettre à jour l'annonce dans la base de données
$annonce->update();


// AJOUT DES NOUVELLES PHOTOS

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

            // Les nouvelles photos ne sont pas principales
            $photo->set("principale",0);

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