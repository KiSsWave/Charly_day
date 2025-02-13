<script setup>
import { ref, onMounted } from "vue";

const iframeVisible = ref(false);
const konamiCode = [
  "ArrowUp", "ArrowUp", "ArrowDown", "ArrowDown",
  "ArrowLeft", "ArrowRight", "ArrowLeft", "ArrowRight",
  "b", "a"
];
let userInput = [];

onMounted(() => {
  window.addEventListener("keydown", (event) => {
    userInput.push(event.key);

    if (userInput.join("").toLowerCase().includes(konamiCode.join("").toLowerCase())) {
      iframeVisible.value = true;
    }

    if (userInput.length > konamiCode.length) {
      userInput.shift();
    }
  });
});
</script>

<template>
  <div class="wrapper">
    <iframe
      v-if="iframeVisible"
      src="https://subway-surfers.org/berlin/"
      style="border: none;"
    ></iframe>
  </div>
</template>

<style scoped>
.wrapper {
  width: 100%;
  height: 100dvh;
}

iframe {
  width: 100%;
  height: 100dvh;
}
</style>
