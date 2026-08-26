/*
Librairies des fonctions spécifiques générales du projet
*/

/*==========================================================  
         role : recherche artiste 
===========================================================*/

let form = document.getElementById("searchForm");

if (form)
  form.addEventListener("submit", function (e) {
    e.preventDefault();

    rechercherArtistes();
  });

function rechercherArtistes() {
  let type = document.querySelector("#type").value;
  let region = document.querySelector("#region").value;

  fetch(
    "recherche-artiste-ajax.php?type=" +
      //transformer un texte pour qu'il puisse être envoyé dans une URL en utilisant encodeURIComponent
      encodeURIComponent(type) +
      "&region=" +
      encodeURIComponent(region),
  )
    .then((response) => response.text())
    .then((html) => {
      document.querySelector("#resultat-recherche-artiste").innerHTML = html;
    });
}
/*==========================================================  
      role : ouvrir une conversation 
===========================================================*/
function ouvrirConversation(artisteId) {
  fetch("conversation-ajax.php?id=" + artisteId)
    .then((response) => response.text())
    .then((html) => {
      document.querySelector("#zone-message").innerHTML = html;
      SendMessage();
    });
}

/*=====================================================================  
      role : Rafraîchissement automatique de la liste de conversation 
=====================================================================*/
//
/*function rafraichirListeConversations() {
  console.log("test rafraichirListeConversations");
  fetch("liste-conversations-ajax.php")
    .then((response) => response.text())
    .then((fragment) => {
      document.getElementById("liste-conversations").innerHTML = fragment;
    });
}
rafraichirListeConversations();

// Rafraîchissement automatique de la conversation

setInterval(function () {
  console.log("test setInterval liste de conversation");

  rafraichirListeConversations();
}, 1000044444440000);*/

/*==========================================================  
         role : envoyer un message 
===========================================================*/

function SendMessage() {
  //role : envoyer un message sans recharger la page
  let form = document.getElementById("message-a-saisir-select");

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    //creer un FormData (objet js) qui va contenir le contenu du formulaire
    let formData = new FormData(this);

    //envoyer une requete HTTP POST vers traiter-message.php
    fetch("traiter-message.php", { method: "POST", body: formData })
      .then((response) => response.text())
      .then(() => {
        //vider le formulaire avec la methode reset
        document.getElementById("message-a-saisir-select").reset();

        //enlever le formulaire
        document.getElementById("zone-message").innerHTML = "";
      });
  });
}

/*==========================================================  
         role : afficher le detail d'une conversation
===========================================================*/
let idActuel = null;
function detailConversation(id) {
  idActuel = id;

  fetch("detail-conversation-ajax.php?id=" + id)
    .then((data) => data.text())
    .then((fragment) => {
      document.getElementById("detail-conversation").innerHTML = fragment;

      // Mettre en bas de page le scroll pour afficher le dernier message
      setTimeout(() => {
        let conversation = document.querySelector(".conversation");

        if (conversation) {
          conversation.scrollTop = conversation.scrollHeight;
        }
      }, 50);

      FormMessage();
      refreshUnreadCount();
    });
}

/*==========================================================  
      role : Rafraîchissement automatique de la conversation
===========================================================*/

/*setInterval(function () {
  console.log("test setInterval detail de conversation", idActuel);
  if (idActuel !== null) {
    detailConversation(idActuel);
  }
}, 15000);*/

/*==========================================================  
         role : envoyer un message sans recharger la page
===========================================================*/
function FormMessage() {
  console.log("test FormMessage");
  let form = document.getElementById("message-a-saisir");

  form.addEventListener("submit", function (e) {
    e.preventDefault();

    //FormData est une fonction JavaScript intégrée qui parcourt automatiquement tous les champs du formulaire (inputs, textarea, selects, etc.) et construit un jeu de données prêt à être envoyé en HTTP.

    //Cela évite de devoir récupérer manuellement chaque champ (ex : document.querySelector('textarea[name="message"]').value)

    //fetch est une fonction moderne pour envoyer des requêtes réseau (AJAX) sans recharger la page.
    //url = "traiter-message.php" : le script PHP qui va traiter les données (votre script d'insertion).

    //fetch se charge d’envoyer les données (message, nom, etc.) à traiter-message.php sans recharger la page.

    /*method: "POST" : on envoie les données via la méthode HTTP POST (comme un formulaire classique).
s
    //body: formData : on transmet les données collectées du formulaire dans le corps de la requête.*/

    let formData = new FormData(this);

    fetch("traiter-message.php", { method: "POST", body: formData })
      .then((response) => response.text())
      .then(() => {
        detailConversation(idActuel);
        form.reset();
      });
  });
}

/*==========================================================  
         role : archiver conversation
===========================================================*/

function archiverConversation(id) {
  console.log("test archive");
  fetch("archiver-ajax.php?id=" + id).then(() => {
    rafraichirListeConversations();
  });
}

/*debug // affichera les var_dump

function archiverConversation(id) {
  console.log("test archive");

  fetch("archiver-ajax.php?id=" + id)
    .then(response => response.text())
    .then(data => {
      console.log(data); 
    });
}*/
function refreshUnreadCount() {
  //role : actualiser le nombre de message non lus
  fetch("count-unread-ajax.php")
    .then((response) => response.text())
    .then((nb) => {
      document.getElementById("nb-unread-total").innerText = nb;
    });
}

/*====================================================================  
    
    role : afficher le formulaire de modification du profil
      
======================================================================*/
function ModifierProfil() {
  //role : afficher le formulaire

  fetch("modifier-profil-ajax.php")
    .then((response) => response.text())
    .then((html) => {
      //inserer le html ds la div
      document.getElementById("zone-profil").innerHTML = html;
      document.getElementById("zone-profil").style.display = "block";
    });
}

/*===============================================================  
      role : valider la modification du profil artiste 
================================================================*/

function validerModification() {
  //role : valider la modification
  //creer un FormData qui va contenir le contenu du formulaire

  let form = document.getElementById("form-modif-profil");

  let data = new FormData(form);

  //envoyer une requete HTTP POST vers valider-modif-profil-ajax
  fetch("valider-modif-profil-artiste-ajax.php", {
    method: "POST",
    body: data,
  })
    //recuperer la reponse de la requete format json
    .then((response) => response.json())
    .then((response) => {
      let msg = document.getElementById("msg-modif");
      //inserer le message ds la div
      msg.innerHTML = response.message;

      //afficher le block apres suppression ds setTimout
      msg.style.display = "block";

      //si true afficher le message en vert
      if (response.success) {
        msg.style.color = "green";

        document.getElementById("zone-profil").style.display = "none";
        document.getElementById("zone-profil").innerHTML = "";
      } else {
        msg.style.color = "red";
      }

      //supprimer le message apres 3 secondes

      setTimeout(() => {
        document.getElementById("msg-modif").style.display = "none";
      }, 3000);
    })

    //cath en cas d'erreur execution php
    .catch(() => {
      let msg = document.getElementById("msg-modif");

      msg.innerHTML = "Une erreur est survenue.";
      msg.style.color = "red";
      msg.style.display = "block";
    });
}

/*===============================================================  
      role : valider la modification du profil organisateur 
================================================================*/

function validerModificationOrganisateur() {
  //role : valider la modification
  //creer un FormData qui va contenir le contenu du formulaire

  let form = document.getElementById("form-modif-profil");

  let data = new FormData(form);

  //envoyer une requete HTTP POST vers valider-modif-profil-ajax
  fetch("valider-modif-profil-orga-ajax.php", {
    method: "POST",
    body: data,
  })
    //recuperer la reponse de la requete format json
    .then((response) => response.json())
    .then((response) => {
      let msg = document.getElementById("msg-modif");
      //inserer le message ds la div
      msg.innerHTML = response.message;

      //afficher le block apres suppression ds setTimout
      msg.style.display = "block";

      //si true afficher le message en vert
      if (response.success) {
        msg.style.color = "green";

        document.getElementById("zone-profil").style.display = "none";
        document.getElementById("zone-profil").innerHTML = "";
      } else {
        msg.style.color = "red";
      }

      //supprimer le message apres 3 secondes

      setTimeout(() => {
        document.getElementById("msg-modif").style.display = "none";
      }, 3000);
    })

    //cath en cas d'erreur execution php
    .catch(() => {
      let msg = document.getElementById("msg-modif");

      msg.innerHTML = "Une erreur est survenue.";
      msg.style.color = "red";
      msg.style.display = "block";
    });
}
