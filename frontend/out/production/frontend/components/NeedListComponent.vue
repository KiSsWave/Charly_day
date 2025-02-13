<template>
  <div class="need-list">
    <div class="title">
      <img src="@/assets/charly_list.png" alt="Charly qui montre une liste">
      <h1>Liste des besoins</h1>
    </div>
    <div v-for="(need, index) in needs" :key="index">
      <NeedPreview :Need="need" />
    </div>
  </div>
</template>

<script>
import NeedPreview from './NeedPreviewComponent.vue';

export default {
  name: 'NeedList',
  components: {
    NeedPreview
  },
  data() {
    return {
      needs: [
        {
          client_name: "Jean Dupont",
          description: "Développement d'une application mobile pour la gestion de projet",
          competence_type: "Développement mobile",
          created_at: "2025-01-13T14:30:00Z",
          status: "Disponible"
        },
        {
          client_name: "Sophie Martin",
          description: "Création d'un site web de e-commerce",
          competence_type: "Web design et développement",
          created_at: "2025-02-10T09:00:00Z",
          status: "Indisponible"
        },
        {
          client_name: "Pierre Lefevre",
          description: "Mise en place d'une solution ERP",
          competence_type: "Gestion des systèmes d'information",
          created_at: "2025-02-12T11:45:00Z",
          status: "Disponible"
        }
      ]
    };
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
</style>
