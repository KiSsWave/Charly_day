<template>
  <div class="auth-container">
    <div class="auth-card">
      <div class="auth-header">
        <h2 class="auth-title">Connexion à votre compte</h2>
      </div>

      <form class="auth-form" @submit.prevent="handleLogin">
        <div class="form-group">
          <label for="email" class="form-label">Adresse email</label>
          <input
            id="email"
            v-model="form.email"
            type="email"
            required
            class="form-input"
            placeholder="Adresse email"
          />
        </div>

        <div class="form-group">
          <label for="password" class="form-label">Mot de passe</label>
          <input
            id="password"
            v-model="form.password"
            type="password"
            required
            class="form-input"
            placeholder="Mot de passe"
          />
        </div>
        <p class="auth-subtitle">
          Vous n'avez pas de compte?
          <label @click="register" class="link">Créez un nouveau compte</label>
        </p>
        <button type="submit" :disabled="isLoading" class="auth-button">
          <span v-if="isLoading" class="loading-spinner"></span>
          {{ isLoading ? "Connexion..." : "Se connecter" }}
        </button>

        <div v-if="error" class="error-message">
          {{ error }}
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: "LoginView",

  data() {
    return {
      form: {
        email: "",
        password: "",
      },
      isLoading: false,
      error: null,
    };
  },

  methods: {
    async handleLogin() {
      this.isLoading = true;
      this.error = null;

      try {
        const response = await fetch("http://localhost:49050/signing", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
          },
          body: JSON.stringify(this.form),
        });

        const { token } = response.data;
        localStorage.setItem("token", token);

        this.$router.push({ name: "home" });
      } catch (error) {
        this.error =
          error.response?.data?.message ||
          "Une erreur est survenue lors de la connexion.";
      } finally {
        this.isLoading = false;
      }
    },
    register() {
      this.$router.push({ name: "register" });
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
  min-height: 100vh;
  display: flex;
  align-items: center;
  justify-content: center;
  background: linear-gradient(135deg, #f5f7fa 0%, #e4e8eb 100%);
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
}

.form-input:focus {
  outline: none;
  border-color: #3182ce;
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
  background-color: #3182ce;
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
  background-color: #2c5282;
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
