// affichage profil artiste ou organisateur

const radios = document.querySelectorAll('input[name="role"]');

const profilArtiste = document.getElementById("profil-artiste");
const profilOrganisateur = document.getElementById("profil-organisateur");

radios.forEach((radio) => {
  radio.addEventListener("change", function () {
    if (this.value === "artiste") {
      profilArtiste.style.display = "block";
      profilOrganisateur.style.display = "none";
    }

    if (this.value === "organisateur") {
      profilArtiste.style.display = "none";
      profilOrganisateur.style.display = "block";
    }
  });
});

//faire disparaitre le message d envoi email sur le dashboard
document.addEventListener("DOMContentLoaded", () => {
  console.log("JS chargé");
  setTimeout(() => {
    const msg = document.getElementById("msg-success-echec");

    if (msg) {
      msg.style.transition = "opacity 0.5s";
      msg.style.opacity = "0";

      setTimeout(() => {
        msg.remove();
      }, 500);
    }
  }, 3000);
});

//toogle cacher mot de passe
document
  .getElementById("togglePassword")
  .addEventListener("click", function () {
    const input = document.getElementById("password");

    if (input.type === "password") {
      input.type = "text";
      this.classList.remove("fa-eye-slash");
      this.classList.add("fa-eye");
    } else {
      input.type = "password";
      this.classList.remove("fa-eye");
      this.classList.add("fa-eye-slash");
    }
  });

// fermer modif profil
function fermerProfil() {
  console.log("fermerProfil");
  document.getElementById("zone-profil").innerHTML = "";
}
