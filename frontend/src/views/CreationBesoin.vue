<template>
  <div class="create-need-container max-w-2xl mx-auto p-6">
    <h2 class="text-2xl font-bold mb-6">Exprimer un besoin</h2>

    <form @submit.prevent="submitNeed" class="space-y-6">
      <div v-if="showSuccess" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
        Votre besoin a été enregistré avec succès !
        <button @click="showSuccess = false" class="absolute top-0 right-0 px-4 py-3">
          ×
        </button>
      </div>

      <div class="form-group">
        <label class="block text-gray-700 text-sm font-bold mb-2">
          Nom du client ou de l'entreprise *
        </label>
        <input
          v-model="form.clientName"
          type="text"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          :class="{ 'border-red-500': errors.clientName }"
          placeholder="Ex: Entreprise ABC"
        >
        <p v-if="errors.clientName" class="text-red-500 text-xs italic">
          {{ errors.clientName }}
        </p>
      </div>

      <!-- Libellé du besoin -->
      <div class="form-group">
        <label class="block text-gray-700 text-sm font-bold mb-2">
          Description du besoin *
        </label>
        <textarea
          v-model="form.description"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 mb-3 leading-tight focus:outline-none focus:shadow-outline"
          :class="{ 'border-red-500': errors.description }"
          rows="4"
          placeholder="Décrivez votre besoin en détail..."
        ></textarea>
        <p v-if="errors.description" class="text-red-500 text-xs italic">
          {{ errors.description }}
        </p>
      </div>

      <!-- Compétence requise -->
      <div class="form-group">
        <label class="block text-gray-700 text-sm font-bold mb-2">
          Compétence requise *
        </label>
        <select
          v-model="form.competence"
          class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
          :class="{ 'border-red-500': errors.competence }"
        >
          <option value="">Sélectionnez une compétence</option>
          <option v-for="competence in competences"
                  :key="competence.code"
                  :value="competence.code">
            {{ competence.name }}
          </option>
        </select>
        <p v-if="errors.competence" class="text-red-500 text-xs italic">
          {{ errors.competence }}
        </p>
      </div>

      <!-- Boutons -->
      <div class="flex items-center justify-between">
        <button
          type="submit"
          class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
          :disabled="isSubmitting"
        >
          {{ isSubmitting ? 'Enregistrement...' : 'Enregistrer le besoin' }}
        </button>
        <button
          type="button"
          @click="resetForm"
          class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
        >
          Réinitialiser
        </button>
      </div>
    </form>
  </div>
</template>

<script>
import { ref, reactive } from 'vue'

export default {
  name: 'CreateNeed',

  setup() {
    const competences = [
      { code: 'BR', name: 'Bricolage' },
      { code: 'JD', name: 'Jardinage' },
      { code: 'MN', name: 'Ménage' },
      { code: 'IF', name: 'Informatique' },
      { code: 'AD', name: 'Administratif' }
    ]

    const form = reactive({
      clientName: '',
      description: '',
      competence: ''
    })

    const errors = reactive({
      clientName: '',
      description: '',
      competence: ''
    })

    const isSubmitting = ref(false)
    const showSuccess = ref(false)

    const validateForm = () => {
      let isValid = true

      errors.clientName = ''
      errors.description = ''
      errors.competence = ''

      if (!form.clientName.trim()) {
        errors.clientName = 'Le nom du client est requis'
        isValid = false
      }

      if (!form.description.trim()) {
        errors.description = 'La description du besoin est requise'
        isValid = false
      } else if (form.description.trim().length < 10) {
        errors.description = 'La description doit contenir au moins 10 caractères'
        isValid = false
      }

      // Validation de la compétence
      if (!form.competence) {
        errors.competence = 'La sélection d\'une compétence est requise'
        isValid = false
      }

      return isValid
    }

    const submitNeed = async () => {
      if (!validateForm()) {
        return
      }

      isSubmitting.value = true

      try {
        const needData = {
          clientName: form.clientName.trim(),
          description: form.description.trim(),
          competence: form.competence,
          createdAt: new Date().toISOString()
        }

        const response = await fetch('/api/needs', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json'
          },
          body: JSON.stringify(needData)
        })

        if (!response.ok) {
          throw new Error('Erreur lors de la création du besoin')
        }

        resetForm()
        showSuccess.value = true

        setTimeout(() => {
          showSuccess.value = false
        }, 5000)

      } catch (error) {
        console.error('Erreur:', error)
        alert('Une erreur est survenue lors de l\'enregistrement du besoin')
      } finally {
        isSubmitting.value = false
      }
    }

    const resetForm = () => {
      form.clientName = ''
      form.description = ''
      form.competence = ''
      errors.clientName = ''
      errors.description = ''
      errors.competence = ''
      showSuccess.value = false
    }

    return {
      form,
      errors,
      competences,
      isSubmitting,
      showSuccess,
      submitNeed,
      resetForm
    }
  }
}
</script>

<style scoped>
.create-need-container {
  background-color: #ffffff;
  border-radius: 12px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  padding: 2rem;
  transition: transform 0.3s ease-in-out;
}

.create-need-container:hover {
  transform: scale(1.02);
}

h2 {
  color: #2c3e50;
  text-align: center;
}

input,
textarea,
select {
  width: 100%;
  padding: 0.75rem;
  border-radius: 8px;
  border: 1px solid #ccc;
  transition: border-color 0.3s;
}

input:focus,
textarea:focus,
select:focus {
  border-color: #3498db;
  outline: none;
  box-shadow: 0 0 5px rgba(52, 152, 219, 0.5);
}

input.border-red-500,
textarea.border-red-500,
select.border-red-500 {
  border-color: #e74c3c;
}

.text-red-500 {
  color: #e74c3c;
  font-size: 0.85rem;
}

button {
  padding: 0.75rem 1.5rem;
  border-radius: 8px;
  font-weight: bold;
  transition: background-color 0.3s ease-in-out, transform 0.2s;
}

button:disabled {
  background-color: #bdc3c7;
  cursor: not-allowed;
}

button:hover:not(:disabled) {
  transform: translateY(-2px);
}

.bg-blue-500 {
  background-color: #3498db;
  color: white;
}

.bg-blue-500:hover {
  background-color: #2980b9;
}

.bg-gray-300 {
  background-color: #ecf0f1;
}

.bg-gray-300:hover {
  background-color: #bdc3c7;
}

.bg-green-100 {
  background-color: #d4edda;
  border: 1px solid #28a745;
  color: #155724;
  padding: 1rem;
  border-radius: 8px;
  position: relative;
  text-align: center;
}

.success-message-enter-active,
.success-message-leave-active {
  transition: opacity 0.5s;
}

.success-message-enter,
.success-message-leave-to {
  opacity: 0;
}

</style>
