<template>
  <footer class="footer">
    <div class="footer-content">
      <p>&copy; 2025 Charly. Tous droits réservés.</p>
      <nav>
        <ul>
          <li><a href="#privacy">Politique de confidentialité</a></li>
          <li><a href="#terms">Conditions d'utilisation</a></li>
          <li><a href="#sitemap">Plan du site</a></li>
        </ul>
      </nav>
    </div>
  </footer>
</template>

<script>
export default {
  name: "FooterComponent"
};
</script>

<style scoped>
.footer {
  background-color: red;
  color: white;
  padding: 2rem 1rem;
  text-align: center;
}

.footer-content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  max-width: 1200px;
  margin: 0 auto;
}

footer p {
  margin: 0;
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
