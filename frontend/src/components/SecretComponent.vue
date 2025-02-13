<script setup>
import { ref, onMounted } from "vue";

// Liste des secrets (facilement extensible)
const secrets = {
  konami: {
    code: ["ArrowUp", "ArrowUp", "ArrowDown", "ArrowDown", "ArrowLeft", "ArrowRight", "ArrowLeft", "ArrowRight", "b", "a"],
    content: "iframe",
    src: "https://subway-surfers.org/berlin/"
  },
  bassem: {
    code: ["b", "a", "s", "s", "e", "m"],
    content: "iframe",
    src: "https://www.youtube.com/embed/3f8LGyeDynE?autoplay=1"
  }
};

// État pour afficher le secret
const secretVisible = ref(false);
const secretContent = ref(null);
const secretSrc = ref("");

let userInput = [];

// Fonction pour vérifier les secrets
const checkSecrets = () => {
  Object.values(secrets).forEach(secret => {
    if (userInput.join("").includes(secret.code.join("").toLowerCase())) {
      secretVisible.value = true;
      secretContent.value = secret.content;
      secretSrc.value = secret.src;
      userInput = []; // Réinitialise l'entrée utilisateur après activation du secret
    }
  });

  // Garde uniquement les entrées nécessaires
  const maxCodeLength = Math.max(...Object.values(secrets).map(secret => secret.code.length));
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
};
</script>

<template>
  <div class="wrapper">
    <!-- Modale affichée lorsqu'un secret est actif -->
    <div v-if="secretVisible" class="secret-modal">
      <button class="close-btn" @click="closeSecret">✖</button>
      <iframe v-if="secretContent === 'iframe'" :src="secretSrc" frameborder="0" allowfullscreen></iframe>
    </div>
  </div>
</template>

<style scoped>
/* Pleine page pour la gestion */
.wrapper {
  width: 100%;
  height: 100dvh;
}

/* Modale secrète */
.secret-modal {
  position: fixed;
  top: 50%;
  Right: 0%;
  transform: translateY(-50%);
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
  width: 430px;
  height: 920px;
  max-width: 90vw;
  max-height: 90vh;
  border-radius: 10px;
}
</style>
