<template>
  <div class="admin-view">
    <AdminComponent />
    <router-view />
  </div>
</template>

<script>
import AdminComponent from '@/components/AdminComponent.vue';

export default {
  name: "AdminView",
  components: {
    AdminComponent,
  },
};
</script>

<style scoped>
.admin-view {
  display: flex;
}

.admin-menu {
  width: 250px;
  background-color: #f4f4f4;
  padding: 20px;
}
</style>
