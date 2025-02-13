<template>
  <HeaderComponent />
  <div class="admin-view">
    <AdminComponent />
    <RouterView />
  </div>
  <FooterComponent />
</template>

<script>
import AdminComponent from '@/components/AdminComponent.vue';
import FooterComponent from '@/components/FooterComponent.vue';
import HeaderComponent from '@/components/HeaderComponent.vue';

export default {
  name: "AdminView",
  components: {
    AdminComponent,
    FooterComponent,
    HeaderComponent,
  },
};
</script>

<style scoped>
.admin-view {
  display: flex;
  flex-direction: column;
  min-height: 80vh;
}

</style>
