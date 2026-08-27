<?php
/*

Rôle : valider l'ajout d'une annonce dans la BDD
Parametre : les données du formulaire

*/

require_once "libr/init.php";

// Récupérer les données du formulaire
$titre        = trim($_POST["titre"] ?? "");
$categorie = $_POST["categorie"] ?? "";
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

// Créer l'objet annonce
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

if ($resultat) {

    $_SESSION["success_annonce"] = "✅ Annonce créée avec succès";

    header("Location: dashbord.php");
    exit;
}

// Erreur
$_SESSION["error_annonce"] = "Erreur lors de la création de l'annonce ❌";

header("Location: annonce.php");
exit;