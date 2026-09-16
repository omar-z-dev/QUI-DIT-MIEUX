<===================================================
Architecture du projet
===================================================>

1-Dossier documents on y trouve les schéma d'ergonomie et le schéma MCD MPD, l'appli est accessible via le lien : https://qdm-omar.play.mywebecom.ovh

2-Dossier CORE on y trouve les fichiers :
-api.php : la classe qui gère l'accès à l'API
-model.php : classe \_model qui hérite ses méthode aux autre classes du projet
-recaptcha.php : la classe qui gère les connexion anti robots

3-Dosssier libr :
-init.php : les différentes initialisations y compris le chargement auto des classes
-session.php : gérer la session de l'appli

4-Dossier modele : les différentes classes de l'appli

5-Dossier templates qui comprend les sous dossiers :

     forms : formulaire de recherche utilisé dans l'appli
     fragments : les fragments utilisés
     pages : les différentes views de l'appli

6-Les controllers sont à la racine du dossier QUI-DIT-MIEUX

7-Dossier js : fichier du script js utilisé en ajax

<==================================================
Infos sur les fichiers
==================================================>

Chaque fichier utilisé dans l'appli comporte une entete en commentaire expliquant la nature du fichier (controler ou template) , son rôle et les Paramètres utilisés.

Par exemple pour le controler auth.php on a un commentaire en entete comme suit :

/\*

CONTROLEUR :
Rôle : gérer l'authentification et l'inscription des utilisateurs

Paramètres : action (login ou register) et les données du formulaire (identifiant, mot de passe, pseudo, email)

\*/
