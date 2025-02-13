<template>
  <div class="create-employee">
    <div class="card">
      <h2>Créer un salarié</h2>
      <form @submit.prevent="createEmployee">
        <div class="form-group">
          <label for="name">Nom</label>
          <input type="text" id="name" v-model="employee.name" required />
        </div>
        <button type="submit">Créer le salarié</button>
      </form>
    </div>
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
      },
    };
  },
  methods: {
    async createEmployee() {
      try {
        await axios.post('/salaries', this.employee);
        alert("Salarié créé avec succès");
        this.$router.push('/admin/needs');
      } catch (error) {
        console.error("Erreur lors de la création du salarié : ", error);
      }
    },
  },
};
</script>

<style scoped>
.create-employee {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: 50vh;
  background: linear-gradient(135deg, #f5f7fa, #c3cfe2);
}

.card {
  background: white;
  padding: 25px;
  border-radius: 12px;
  box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
  max-width: 400px;
  width: 100%;
  text-align: center;
}

h2 {
  color: #333;
  margin-bottom: 20px;
}

.form-group {
  display: flex;
  flex-direction: column;
  text-align: left;
}

label {
  font-weight: bold;
  margin-bottom: 5px;
  color: #555;
}

input {
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 8px;
  font-size: 16px;
  transition: border-color 0.3s ease;
}

input:focus {
  border-color: #e71e1e;
  outline: none;
}

button {
  background: #e71e1e;
  color: white;
  font-size: 16px;
  padding: 12px;
  border: none;
  border-radius: 8px;
  cursor: pointer;
  transition: background 0.3s ease, transform 0.2s ease;
  margin-top: 15px;
  width: 100%;
}

button:hover {
  background: #b10e0e;
  transform: scale(1.05);
}
</style>
