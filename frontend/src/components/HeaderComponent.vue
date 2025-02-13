<template>
  <header class="header">
    <div class="logo">
      <h1>Charly</h1>
    </div>
    <nav>
      <ul>
        <li><a href="#home">Accueil</a></li>
        <li><a href="#about">À propos</a></li>
        <li><a href="#services">Services</a></li>
        <li><a href="#contact">Contact</a></li>
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
  background-color: red;
  padding: 1rem 2rem;
  color: white;
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

nav a {
  color: white;
  text-decoration: none;
  font-size: 1rem;
  transition: color 0.3s;
}

nav a:hover {
  color: #ffcccc;
}
</style>
