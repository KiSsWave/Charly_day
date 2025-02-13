<template>
  <div class="need-list">
    <div class="title">
      <img src="@/assets/charly_list.png" alt="Charly qui montre une liste">
      <h1>Vos besoins</h1>
    </div>

    <!-- Affichage du message de chargement -->
    <p v-if="loading">Chargement des besoins...</p>

    <!-- Affichage du message d'erreur -->
    <p v-if="error" class="error">{{ error }}</p>

    <!-- Affichage du message si aucun besoin -->
    <p v-if="!loading && needs.length === 0" class="empty-message">
      Vous n'avez aucun besoin pour l'instant.
    </p>

    <!-- Affichage des besoins -->
    <div v-for="(need, index) in needs" :key="index">
      <NeedPreview :Need="need" />
    </div>
  </div>
</template>

<script>
import NeedPreview from './NeedPreviewComponent.vue';
import axios from '../api/index.js';
import {isAuthenticated} from '@/services/authProvider.js';

export default {
  name: 'NeedList',
  components: {
    NeedPreview
  },
  data() {
    return {
      needs: [],  // Tableau vide par défaut
      loading: true, // Indicateur de chargement
      error: null   // Gestion des erreurs
    };
  },
  mounted() {
    this.fetchNeeds();
  },
  methods: {
    async fetchNeeds() {
      try {
        this.loading = true;
        let response;

        if (!isAuthenticated()) {
          // Si l'utilisateur n'est pas authentifié, on appelle l'endpoint correspondant
          response = await axios.get('/needs/anonymous');
        } else {
          // Si l'utilisateur est authentifié, on appelle l'endpoint général
          response = await axios.get('/needs');
        }

        // Accès au tableau 'needs' dans la réponse
        this.needs = response.data.needs;

      } catch (err) {
        this.error = "Erreur lors du chargement des besoins.";
        console.error("Erreur Axios:", err);
      } finally {
        this.loading = false; // Fin du chargement
      }
    }
  }
}
</script>


<style scoped>
.title {
  display: flex;
  justify-content: center;
  align-items: center;
  margin-bottom: 20px;
}

.title img {
  height: 150px;
}

.title h1 {
  font-size: 2em;
  color: #ffffff;
  margin-left: 10px;
}

.need-list {
  padding: 16px;
  background-color: #b10e0e;
  color: white;
  box-sizing: border-box;
  width: 90%;
  border-radius: 24px;
}

.need-list h1 {
  font-size: 1em;
  color: #ffffff;
  margin-bottom: 20px;
}

.error {
  color: yellow;
  font-weight: bold;
  text-align: center;
}

.empty-message {
  text-align: center;
  font-style: italic;
  color: #ffffff;
  margin-top: 20px;
}
</style>
