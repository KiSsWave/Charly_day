<template>
  <HeaderComponent />
  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-header">
        <h2 class="auth-title">Créer un nouveau compte</h2>
      </div>

      <form class="auth-form" @submit.prevent="handleRegister">
        <div class="form-group">
          <label class="form-label" for="login">Nom complet</label>
          <input
            id="login"
            v-model="form.login"
            type="text"
            class="form-input"
            placeholder="Nom complet"
            required
          />
        </div>

        <div class="form-group">
          <label class="form-label" for="email">Adresse email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            class="form-input"
            placeholder="Adresse email"
            required
          />
        </div>

        <div class="form-group">
          <label class="form-label" for="password">Mot de passe</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            class="form-input"
            placeholder="Mot de passe"
            required
          />
        </div>

        <div class="form-group">
          <label class="form-label" for="password_confirmation"
            >Confirmation du mot de passe</label
          >
          <input
            id="password_confirmation"
            v-model="password_confirmation"
            type="password"
            class="form-input"
            placeholder="Confirmation du mot de passe"
            required
          />
        </div>

        <p class="auth-subtitle">
          Vous avez déjà un compte ?
          <label @click="login" class="auth-link link">
            Connectez-vous
          </label>
        </p>

        <button type="submit" class="auth-button" :disabled="isLoading">
          <span v-if="!isLoading">Créer un compte</span>
          <span v-else class="loading-spinner"></span>
        </button>

        <p v-if="error" class="error-message">{{ error }}</p>
      </form>
    </div>
  </div>
  <FooterComponent />
</template>

<script>
import HeaderComponent from "@/components/HeaderComponent.vue";
import axios from "../api";
import FooterComponent from "@/components/FooterComponent.vue";

export default {
  name: "RegisterView",
  components: {
    HeaderComponent,
    FooterComponent,
  },
  data() {
    return {
      form: {
        login: "",
        email: "",
        password: "",
      },
      password_confirmation: "",
      isLoading: false,
      error: null,
    };
  },
  methods: {
    async handleRegister() {
      if (this.form.password !== this.password_confirmation) {
        this.error = "Les mots de passe ne correspondent pas.";
        return;
      }

      this.isLoading = true;
      this.error = null;

      try {
        await axios.post("/register", this.form);
        this.$router.push({ name: "login" });
      } catch (error) {
        this.error =
          error.response?.data?.message ||
          "Une erreur est survenue lors de la création du compte.";
      } finally {
        this.isLoading = false;
      }
    },
    login() {
      this.$router.push({ name: "login" });
    },
  },
};
</script>

<style scoped>
.link {
  color: #3182ce;
  text-decoration: none;
  font-weight: 500;
  transition: color 0.2s ease;
  cursor: pointer;
}
.link:hover {
  color: #2c5282;
}

.auth-container {
  min-height: 80dvh;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;
}

/* Carte du formulaire */
.auth-card {
  background: white;
  border-radius: 1rem;
  box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
  width: 100%;
  max-width: 440px;
  padding: 2rem;
}

/* En-tête */
.auth-header {
  text-align: center;
  margin-bottom: 2rem;
}

.auth-title {
  font-size: 1.875rem;
  font-weight: 700;
  color: #1a202c;
  margin-bottom: 0.5rem;
}

.auth-subtitle {
  font-size: 0.875rem;
  color: #4a5568;
}

.auth-subtitle a {
  color: #3182ce;
  text-decoration: none;
  font-weight: 500;
  transition: color 0.2s ease;
}

.auth-subtitle a:hover {
  color: #2c5282;
}

/* Formulaire */
.auth-form {
  margin-top: 2rem;
}

.form-group {
  margin-bottom: 1.5rem;
}

.form-group:last-child {
  margin-bottom: 0;
}

.form-label {
  display: block;
  font-size: 0.875rem;
  font-weight: 500;
  color: #4a5568;
  margin-bottom: 0.5rem;
}

.form-input {
  width: 100%;
  padding: 0.75rem 1rem;
  border: 1px solid #e2e8f0;
  border-radius: 0.5rem;
  font-size: 0.875rem;
  color: #1a202c;
  transition: all 0.2s ease;
  box-sizing: border-box;
}

.form-input:focus {
  outline: none;
  border-color: #b10e0e;
  box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.1);
}

.form-input::placeholder {
  color: #a0aec0;
}

.form-input.error {
  border-color: #e53e3e;
}

/* Cases à cocher et radios */
.form-checkbox {
  display: flex;
  align-items: center;
  margin-bottom: 1rem;
}

.form-checkbox input[type="checkbox"] {
  width: 1rem;
  height: 1rem;
  margin-right: 0.5rem;
  border: 1px solid #e2e8f0;
  border-radius: 0.25rem;
  cursor: pointer;
}

.form-checkbox label {
  font-size: 0.875rem;
  color: #4a5568;
  cursor: pointer;
}

/* Bouton de soumission */
.auth-button {
  width: 100%;
  padding: 0.75rem 1.5rem;
  background-color: #d41717;
  color: white;
  border: none;
  border-radius: 0.5rem;
  font-size: 0.875rem;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.2s ease;
  position: relative;
  display: flex;
  align-items: center;
  justify-content: center;
}

.auth-button:hover {
  background-color: #b10e0e;
}

.auth-button:focus {
  outline: none;
  box-shadow: 0 0 0 3px rgba(49, 130, 206, 0.5);
}

.auth-button:disabled {
  background-color: #a0aec0;
  cursor: not-allowed;
}

.auth-button .icon {
  margin-right: 0.5rem;
}

/* Message d'erreur */
.error-message {
  background-color: #fff5f5;
  color: #c53030;
  padding: 0.75rem;
  border-radius: 0.5rem;
  font-size: 0.875rem;
  margin-top: 1rem;
  text-align: center;
}

/* Liens utilitaires */
.utility-links {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-top: 1rem;
  font-size: 0.875rem;
}

.utility-link {
  color: #3182ce;
  text-decoration: none;
  transition: color 0.2s ease;
}

.utility-link:hover {
  color: #2c5282;
}

/* Animation de chargement */
.loading-spinner {
  border: 2px solid rgba(255, 255, 255, 0.3);
  border-radius: 50%;
  border-top: 2px solid white;
  width: 1rem;
  height: 1rem;
  animation: spin 1s linear infinite;
  margin-right: 0.5rem;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}

/* Media Queries */
@media (max-width: 640px) {
  .auth-card {
    padding: 1.5rem;
  }

  .auth-title {
    font-size: 1.5rem;
  }

  .utility-links {
    flex-direction: column;
    gap: 0.75rem;
    text-align: center;
  }
}

/* Transitions */
.fade-enter-active,
.fade-leave-active {
  transition: opacity 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
  opacity: 0;
}

/* Classes d'état des champs */
.input-valid {
  border-color: #48bb78;
}

.input-invalid {
  border-color: #e53e3e;
}

/* Message de validation */
.validation-message {
  font-size: 0.75rem;
  margin-top: 0.25rem;
}

.validation-message.error {
  color: #e53e3e;
}

.validation-message.success {
  color: #48bb78;
}
</style>
