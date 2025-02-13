<template>
  <div class="show-needs">
    <h2>Besoins en cours</h2>
    <div v-if="needs.length === 0">Aucun besoin en cours.</div>
    <ul v-else>
      <li v-for="(need, index) in needs" :key="index">
        <div>
          <strong>{{ need.client_name }}</strong> : {{ need.description }}
          <br />
          Compétence requise : {{ need.competence_type }}
          <br />
          Statut : {{ need.status }}
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import axios from '@/api/index.js';

export default {
  name: "ShowNeeds",
  data() {
    return {
      needs: [],
    };
  },
  created() {
    this.fetchNeeds();
  },
  methods: {
    async fetchNeeds() {
      try {
        const response = await axios.get('/needs');
        this.needs = response.data;
      } catch (error) {
        console.error("Erreur de chargement des besoins : ", error);
      }
    },
  },
};
</script>

<style scoped>
.show-needs {
  padding: 20px;
}

.show-needs h2 {
  text-align: center;
}

.show-needs ul {
  list-style-type: none;
  padding: 0;
}

.show-needs li {
  margin-bottom: 15px;
  border: 1px solid #ccc;
  padding: 10px;
  border-radius: 5px;
}

.show-needs li div {
  font-size: 1.1em;
}
</style>
