<template>
  <HeaderComponent />
  <div class="home">
    <NeedListComponent />
  </div>
  <FooterComponent />
</template>

<script>
import FooterComponent from '@/components/FooterComponent.vue'
import HeaderComponent from '@/components/HeaderComponent.vue'
import NeedListComponent from '@/components/NeedListComponent.vue';

export default {
  name: 'HomeView',
  components: {
    FooterComponent,
    NeedListComponent,
    HeaderComponent
  }
}
</script>

<style>
html, body {
  height: 100%;
  margin: 0;
}

header {
  height: 60px;
  padding: 10px;
  margin-bottom: 10px;
}

footer {
  height: 60px;
  padding: 10px;
  margin-top: 10px;
}

.home {
  display: flex;
  justify-content: center;
  align-items: center;
  min-height: calc(100vh - 60px - 60px - 10px - 10px);
  font-size: 2rem;
  padding: 20px;
  box-sizing: border-box;
}
</style>
