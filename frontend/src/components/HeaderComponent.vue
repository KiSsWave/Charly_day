<template>
  <header class="header">
    <div class="logo" @click="goToHome">
      <img src="@/assets/logo.png" alt="Charly">
      <h1>Charly</h1>
    </div>
    <nav>
      <ul>
        <li><router-link to="/">Accueil</router-link></li>
        <li><router-link to="/need/new">Créer un besoin</router-link></li>
        <li v-if="!isAuthenticated"><router-link to="/login">Connexion</router-link></li>
        <li v-else>
          <button @click="_logout">Déconnexion</button>
        </li>
      </ul>
    </nav>
  </header>
</template>

<script>
import { isAuthenticated, logout } from '@/services/authProvider.js';
import { ref, watchEffect } from 'vue';
import { useRouter } from 'vue-router';

export default {
  name: "HeaderComponent",
  setup() {
    const router = useRouter();
    const authenticated = ref(isAuthenticated());

    watchEffect(() => {
      authenticated.value = isAuthenticated();
    });

    const goToHome = () => {
      router.push({ path: '/' });
    };

    const _logout = () => {
      logout;
      router.push('/');
    };

    return {
      isAuthenticated: authenticated,
      _logout,
      goToHome
    };
  }
};
</script>

<style scoped>
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background-color: #b10e0e;
  padding: 1rem 2rem;
  color: white;
}

.logo {
  display: flex;
  align-items: center;
  cursor: pointer;
}

.logo img {
  width: 75px;
  height: 75px;
  margin-right: 1rem;
  border-radius: 50%;
}

.logo h1 {
  margin: 0;
  font-size: 2rem;
}

nav ul {
  list-style-type: none;
  display: flex;
  gap: 1.5rem;
  margin: 0;
  padding: 0;
}

nav a, nav button {
  color: white;
  text-decoration: none;
  font-size: larger;
  transition: color 0.3s;
  background: none;
  border: none;
  cursor: pointer;
}

nav a:hover, nav button:hover {
  color: #ffcccc;
  text-decoration: underline;
}
</style>
