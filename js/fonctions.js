/*
Librairies des fonctions spécifiques générales du projet
*/

/*==========================================================  

         role : Actualiser l'afficahge de la 
         liste de mes annonces

===========================================================*/
function actualiserMesAnnonces() {
  console.log("actualise Mes Annonces 10 secondes");
  //role : actualiser les annonces
  //Parametres : aucun

  fetch("liste-mes-annonces-ajax.php")
    //Transformer le contenu de la réponse en texte
    .then((response) => response.text())
    .then((html) => {
      //Mettre le HTML récupéré à l'intérieur de cet élément (bloc-mes-annonces)
      document.getElementById("bloc-mes-annonces").innerHTML = html;
    });
}
// Première actualisation au chargement
actualiserMesAnnonces();

// Toutes les 10 secondes executer la fonction
setInterval(actualiserMesAnnonces, 10000);

/*==========================================================  

         role : Actualiser l'afficahge de la 
         liste de mes annonces

===========================================================*/
function actualiserMesSuivis() {
  console.log("actualiser Mes Suivis ttes les 2 secondea");

  fetch("liste-mes-suivis-ajax.php")
    .then((response) => response.text())

    .then((html) => {
      document.getElementById("bloc-mes-suivis").innerHTML = html;
    });
}

// Première actualisation
actualiserMesSuivis();

// Toutes les 2 secondes
setInterval(actualiserMesSuivis, 2000);
