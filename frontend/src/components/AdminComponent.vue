<template>
  <div class="admin-menu">
    <h2>Menu Admin</h2>
    <nav>
      <ul>
        <li><router-link to="/admin/needs">Afficher tous les besoins en cours</router-link></li>
        <li><router-link to="/admin/employee">Créer un salarié</router-link></li>
        <li><router-link to="/admin/skills">Gérer une compétence</router-link></li>
      </ul>
    </nav>
  </div>
</template>

<script>
export default {
  name: "AdminMenu",
};
</script>

<style scoped>
.admin-menu {
  padding: 20px;
  background-color: #f3f3f3;
  border-radius: 8px;
}

.admin-menu h2 {
  text-align: center;
}

.admin-menu nav ul {
  list-style: none;
  padding: 0;
}

.admin-menu nav ul li {
  margin: 10px 0;
}

.admin-menu nav ul li a {
  color: #007bff;
  text-decoration: none;
  font-size: 1.2em;
}

.admin-menu nav ul li a:hover {
  text-decoration: underline;
}
</style>
