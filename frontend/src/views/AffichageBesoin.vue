<template>
  <div class="needs-list-container">
    <!-- <div v-if="!hasActiveSession" class="session-expired">
      <p>Votre session a expiré. Veuillez vous reconnecter ou créer un nouveau besoin pour accéder à la liste.</p>
    </div> -->

    <!-- <div v-else> -->
    <h2 class="text-xl font-bold mb-4">Mes besoins exprimés</h2>
    <!--
      <div v-if="clientNeeds.length === 0" class="empty-state">
        <p>Vous n'avez pas encore exprimé de besoins.</p>
      </div> -->


    <table class="w-full border-collapse">
      <thead>
        <tr>
          <th class="border p-2 text-left">Libellé</th>
          <th class="border p-2 text-left">Compétence requise</th>
          <th class="border p-2 text-left">Statut</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="need in clientNeeds" :key="need.id" class="hover:bg-gray-50">
          <td class="border p-2">{{ need.libelle }}</td>
          <td class="border p-2">
            <span class="px-2 py-1 rounded-full text-sm" :class="getCompetenceClass(need.competence)">
              {{ getCompetenceLabel(need.competence) }}
            </span>
          </td>
          <td class="border p-2">
            <span class="px-2 py-1 rounded-full text-sm"
              :class="need.isAssigned ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'">
              {{ need.isAssigned ? 'Affecté' : 'En attente' }}
            </span>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<script>
const COMPETENCE_LABELS = {
  'BR': 'Bricolage',
  'JD': 'Jardinage',
  'MN': 'Ménage',
  'IF': 'Informatique',
  'AD': 'Administratif'
}

const COMPETENCE_CLASSES = {
  'BR': 'bg-blue-100 text-blue-800',
  'JD': 'bg-green-100 text-green-800',
  'MN': 'bg-purple-100 text-purple-800',
  'IF': 'bg-orange-100 text-orange-800',
  'AD': 'bg-red-100 text-red-800'
}

export default {
  name: 'ClientNeedsList',

  data() {
    return {
      clientNeeds: [],
      hasActiveSession: false
    }
  },

  created() {
    this.checkSession()
    if (this.hasActiveSession) {
      this.fetchClientNeeds()
    }
  },

  methods: {
    checkSession() {
      // Vérifier si une session est active
      const sessionToken = sessionStorage.getItem('clientSessionToken')
      this.hasActiveSession = !!sessionToken
    },

    async fetchClientNeeds() {
      try {
        // Simulation d'un appel API pour récupérer les besoins du client
        // À remplacer par un vrai appel API
        const response = await this.$http.get('/api/client/needs')
        this.clientNeeds = response.data
      } catch (error) {
        console.error('Erreur lors de la récupération des besoins:', error)
        // Gérer l'erreur (afficher un message, etc.)
      }
    },

    getCompetenceLabel(code) {
      return COMPETENCE_LABELS[code] || code
    },

    getCompetenceClass(code) {
      return COMPETENCE_CLASSES[code] || 'bg-gray-100 text-gray-800'
    }
  }
}
</script>

<style scoped>
.needs-list-container {
  max-width: 800px;
  margin: 0 auto;
  padding: 20px;
}

.session-expired,
.empty-state {
  text-align: center;
  padding: 40px;
  background-color: #f9fafb;
  border-radius: 8px;
  margin: 20px 0;
}
</style>
