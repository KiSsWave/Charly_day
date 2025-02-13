<template>
  <div class="manage-skills">
    <h2>Gérer une compétence</h2>
    <form @submit.prevent="manageSkill">
      <div>
        <label for="skill">Compétence</label>
        <input type="text" id="skill" v-model="skill.name" required />
      </div>
      <button type="submit">Ajouter la compétence</button>
    </form>
  </div>
</template>

<script>
import axios from '@/api/index.js';

export default {
  name: "ManageSkills",
  data() {
    return {
      skill: {
        name: '',
      },
    };
  },
  methods: {
    async manageSkill() {
      try {
        await axios.post('/skills', this.skill);
        alert("Compétence ajoutée avec succès");
      } catch (error) {
        console.error("Erreur lors de l'ajout de la compétence : ", error);
      }
    },
  },
};
</script>

<style scoped>
.manage-skills {
  padding: 20px;
}

.manage-skills h2 {
  text-align: center;
}

.manage-skills form {
  max-width: 400px;
  margin: 0 auto;
}

.manage-skills form div {
  margin-bottom: 10px;
}

.manage-skills form button {
  background-color: #007bff;
  color: white;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}

.manage-skills form button:hover {
  background-color: #0056b3;
}
</style>
