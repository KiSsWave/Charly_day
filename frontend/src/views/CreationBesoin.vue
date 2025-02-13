<template>
  <HeaderComponent />
  <div class="create-need">
    <div class="container">
      <h1 class="title">Créer un besoin</h1>
      <form @submit.prevent="submitForm">
        <div class="form-group">
          <label for="client_name">Nom de l'entreprise</label>
          <input type="text" id="client_name" v-model="form.companyName" placeholder="Nom" required />
        </div>

        <div class="form-group">
          <label for="description">Description</label>
          <textarea id="description" v-model="form.description" placeholder="Description" required></textarea>
        </div>

        <div class="form-group">
          <label for="competence">Catégorie</label>
          <select id="competence" v-model="form.category" required>
            <option value="" disabled>Sélectionner une compétence</option>
            <option v-for="category in categories" :key="category.id" :value="category.id">
              {{ category.name }}
            </option>
          </select>
        </div>

        <button type="submit" class="btn">Créer</button>
      </form>
    </div>
  </div>
  <FooterComponent />
</template>

<script>
import axios from "../api/index.js";
import { ref, onMounted } from "vue";
import HeaderComponent from "@/components/HeaderComponent.vue";
import FooterComponent from "@/components/FooterComponent.vue";

export default {
  components: { HeaderComponent, FooterComponent },
  setup() {
    const form = ref({
      companyName: "",
      description: "",
      category: "",
    });

    const categories = ref([]);

    const fetchCategories = async () => {
      try {
        const response = await axios.get("/categories");
        categories.value = response.data;
      } catch (error) {
        console.error("Erreur lors du chargement des catégories :", error);
      }
    };

    const submitForm = async () => {
      try {
        await axios.post("/needs", form.value);
        alert("Besoin créé avec succès !");
      } catch (error) {
        console.error("Erreur lors de la création du besoin :", error);
      }
    };

    onMounted(fetchCategories);

    return { form, categories, submitForm };
  },
};
</script>

<style scoped>

.create-need {
  min-height: 80vh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;
}

.container {
  min-width: 600px;
  margin: auto;
  padding: 20px;
  background: #f8f8f8;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}
.title {
  text-align: center;
  margin-bottom: 20px;
}
.form-group {
  margin-bottom: 15px;
}
label {
  display: block;
  font-weight: bold;
}
input, textarea, select {
  width: 100%;
  padding: 8px;
  margin-top: 5px;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}

input:focus, textarea:focus, select:focus{
  outline: none;
  border-color: #b10e0e;
  box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
}

.btn {
  display: block;
  width: 100%;
  padding: 10px;
  background: #d41717;
  color: white;
  border: none;
  border-radius: 4px;
  cursor: pointer;
  transition: 0.24s;
}
.btn:hover {
  background: #b10e0e;
}
</style>
