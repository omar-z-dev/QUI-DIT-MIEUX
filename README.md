<=================== Architecture du projet ================>

1-dossier documents on y trouve les schéma d'ergonomie et le schéma MCD MPD, l'appli est accessible via le lien : https://qdm-omar.play.mywebecom.ovh

2-dossier CORE on y trouve les fichier : api.php : la classe qui gère l'accès à l'API model.php : classe \_model qui hérite ses méthode aux autre classes du projet recaptcha.php : la classe qui gère les connexion anti robots

3-dosssier libr : init.php : les différentes initialisations y compris le chargement auto des classes session.php : gérer la session de l'appli

4-dossier modele : les différentes classes de l'appli

5-dossier templates qui comprend les sous dossiers :

     forms : formulaire de recherche utilisé dans l'appli
     fragments : les fragments utilisés
     pages : les différentes views de l'appli

6- les controllers sont à la racine du dossier QUI-DIT-MIEUX 7-dossier js : fichier su script js utilisé en ajax
