/*
Librairies des fonctions spécifiques générales du projet
*/

/*==========================================================  
         role : Actualiser les annonces
===========================================================*/
function actualiserMesAnnonces() {
  console.log("actualiserMesAnnonces");
  //role : actualiser les annonces
  //Parametres : aucun

  fetch("liste-mes-annonces-ajax.php")
    .then((response) => response.text())
    .then((html) => {
      document.getElementById("bloc-mes-annonces").innerHTML = html;
    });
}
actualiserMesAnnonces();

// Toutes les 10 secondes
setInterval(actualiserMesAnnonces, 10000);
