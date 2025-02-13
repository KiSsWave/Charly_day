<template>
  <header class="header">
    <div class="logo" @click="$router.push({ name: 'HomeView' })">
      <img src="@/assets/logo.png" alt="Charly">
      <h1>Charly</h1>
    </div>
    <nav>
      <ul>
        <li><router-link to="/">Accueil</router-link></li>
        <li><router-link to="/need/new">Créer un besoin</router-link></li>
        <li><router-link to="/login">Connexion</router-link></li>
      </ul>
    </nav>
  </header>
</template>

<script>
export default {
  name: "HeaderComponent"
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

.logo:hover {
  cursor: pointer;
}

nav ul {
  list-style-type: none;
  display: flex;
  gap: 1.5rem;
  margin: 0;
  padding: 0;
}

nav a {
  color: white;
  text-decoration: none;
  font-size: larger;
  transition: color 0.3s;
}

nav a:hover {
  color: #ffcccc;
  text-decoration: underline;
}
</style>
