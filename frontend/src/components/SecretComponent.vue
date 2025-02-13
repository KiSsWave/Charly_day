<script setup>
import { ref, onMounted } from "vue";

// Liste des secrets avec position et taille directement dans la configuration
const secrets = [
  {
    name: "konami",
    code: ["ArrowUp", "ArrowUp", "ArrowDown", "ArrowDown", "ArrowLeft", "ArrowRight", "ArrowLeft", "ArrowRight", "b", "a"],
    content: "iframe",
    src: "https://subway-surfers.org/berlin/",
    position: { top: "50%", right: "0%" }, // Position à droite par défaut
    size: { width: "430px", height: "920px" } // Taille de l'iframe
  },
  {
    name: "bassem",
    code: ["b", "a", "s", "s", "e", "m"],
    content: "iframe",
    src: "https://www.youtube.com/embed/3f8LGyeDynE?autoplay=1",
    position: { top: "20%", left: "20%" }, // Position plus basse à gauche
    size: { width: "560px", height: "315px" } // Taille différente
  },
  {
    name: "bismillah",
    code: ["b", "i", "s", "m", "i", "l", "l", "a", "h"],
    content: "iframe",
    src: "https://www.youtube.com/embed/KuC7FFdIaQg?autoplay=1",
    position: { top: "50%", left: "50%", transform: "translate(-50%, -50%)" }, // Centré au milieu
    size: { width: "640px", height: "360px" } // Format 16:9
  }
];

// État pour afficher le secret
const secretVisible = ref(false);
const secretContent = ref(null);
const secretSrc = ref("");
const secretPosition = ref({});
const secretSize = ref({});

let userInput = [];

// Fonction pour vérifier les secrets
const checkSecrets = () => {
  secrets.forEach(secret => {
    if (userInput.join("").includes(secret.code.join("").toLowerCase())) {
      secretVisible.value = true;
      secretContent.value = secret.content;
      secretSrc.value = secret.src;
      secretPosition.value = secret.position;
      secretSize.value = secret.size;
      userInput = []; // Réinitialise l'entrée utilisateur après activation du secret
    }
  });

  // Garde uniquement les entrées nécessaires
  const maxCodeLength = Math.max(...secrets.map(secret => secret.code.length));
  if (userInput.length > maxCodeLength) {
    userInput.shift();
  }
};

// Ajoute l'écouteur de touches
onMounted(() => {
  window.addEventListener("keydown", (event) => {
    userInput.push(event.key.toLowerCase());
    checkSecrets();
  });
});

// Fonction pour fermer le secret
const closeSecret = () => {
  secretVisible.value = false;
  secretContent.value = null;
  secretSrc.value = "";
  secretPosition.value = {};
  secretSize.value = {};
};
</script>

<template>
  <div class="wrapper">
    <!-- Modale affichée lorsqu'un secret est actif -->
    <div v-if="secretVisible" class="secret-modal"
         :style="{
           top: secretPosition.top,
           left: secretPosition.left,
           right: secretPosition.right,
           width: secretSize.width,
           height: secretSize.height,
           transform: secretPosition.transform || ''
         }">
      <button class="close-btn" @click="closeSecret">✖</button>
      <iframe v-if="secretContent === 'iframe'" :src="secretSrc" frameborder="0" allowfullscreen></iframe>
    </div>
  </div>
</template>

<style scoped>
/* Modale secrète */
.secret-modal {
  position: fixed;
  transform: translateY(-50%); /* Centre verticalement */
  background: rgba(0, 0, 0, 0.8);
  padding: 20px;
  border-radius: 10px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  z-index: 1000;
}

/* Bouton de fermeture */
.close-btn {
  position: absolute;
  top: 10px;
  right: 10px;
  background: white;
  border: none;
  cursor: pointer;
  font-size: 18px;
  padding: 5px 10px;
  border-radius: 50%;
}

/* Style des iframes */
iframe {
  width: 100%;
  height: 100%;
  max-width: 100%;
  max-height: 100%;
  border-radius: 10px;
}
</style>
