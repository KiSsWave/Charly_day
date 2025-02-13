<template>
  <div class="create-employee">
    <h2>Créer un salarié</h2>
    <form @submit.prevent="createEmployee">
      <div>
        <label for="name">Nom</label>
        <input type="text" id="name" v-model="employee.name" required />
      </div>
      <div>
        <label for="email">Email</label>
        <input type="email" id="email" v-model="employee.email" required />
      </div>
      <div>
        <label for="position">Poste</label>
        <input type="text" id="position" v-model="employee.position" required />
      </div>
      <button type="submit">Créer le salarié</button>
    </form>
  </div>
</template>

<script>
import axios from '@/api/index.js';

export default {
  name: "CreateEmployee",
  data() {
    return {
      employee: {
        name: '',
        email: '',
        position: '',
      },
    };
  },
  methods: {
    async createEmployee() {
      try {
        await axios.post('/employees', this.employee);
        alert("Salarié créé avec succès");
        this.$router.push('/admin/needs'); // Redirection vers la liste des besoins
      } catch (error) {
        console.error("Erreur lors de la création du salarié : ", error);
      }
    },
  },
};
</script>

<style scoped>
.create-employee {
  padding: 20px;
}

.create-employee h2 {
  text-align: center;
}

.create-employee form {
  max-width: 400px;
  margin: 0 auto;
}

.create-employee form div {
  margin-bottom: 10px;
}

.create-employee form button {
  background-color: #4CAF50;
  color: white;
  padding: 10px 20px;
  border: none;
  cursor: pointer;
  border-radius: 5px;
}

.create-employee form button:hover {
  background-color: #45a049;
}
</style>
