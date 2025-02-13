<template>
  <div class="need-preview">
    <h2 class="description">{{ Need.description }}</h2>
    <p class="competence">{{ Need.competence_type }}</p>

    <div class="info">
      <div>
        <span class="client-name">Par {{ Need.client_name }} </span>
      </div>

      <div class="tags">
        <span v-if="isRecent" class="new-tag">Nouveau</span>
        <span :class="['status', Need.status.toLowerCase()]">{{ Need.status }}</span>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'NeedPreviewComponent',
  props: {
    Need: {
      type: Object,
      required: true
    }
  },
  computed: {
    formattedDate() {
      const date = new Date(this.Need.created_at);
      return date.toLocaleDateString('fr-FR', {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      });
    },
    isRecent() {
      const createdDate = new Date(this.Need.created_at);
      const currentDate = new Date();
      const diffTime = currentDate - createdDate;
      const diffDays = diffTime / (1000 * 60 * 60 * 24);
      return diffDays < 14; // Moins de 14 jours
    }
  }
}
</script>

<style scoped>
* {
  box-sizing: border-box;
  font-size: smaller;
}

.need-preview {
  padding: 16px;
  border: 1px solid #ddd;
  border-radius: 8px;
  margin: 8px 0;
  background-color: #f9f9f9;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  cursor: pointer;
}

.need-preview:hover {
  transform: scale(1.05);
  box-shadow: 0px 4px 12px rgba(0, 0, 0, 0.1);
}

.description {
  font-size: 1em;
  color: #333;
  margin-bottom: 8px;
}

.competence {
  font-size: 0.9em;
  color: #555;
  margin-bottom: 12px;
}

.info {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.created-at {
  color: #777;
}

.client-name {
  color: #555;
}

.tags {
  display: flex;
  gap: 8px;
}

.status {
  padding: 4px 8px;
  border-radius: 4px;
  font-weight: bold;
}

.status.disponible {
  background-color: green;
  color: white;
}

.status.indisponible {
  background-color: red;
  color: white;
}

.new-tag {
  background-color: rgb(33, 126, 126);
  color: white;
  padding: 4px 8px;
  border-radius: 4px;
  font-weight: bold;
}
</style>
