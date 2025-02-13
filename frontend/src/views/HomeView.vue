<template>
  <div>
    <h1>Home</h1>
    <p>Welcome to the Home page</p>
    <SecretComponent/>
  </div>
</template>

<script>
import SecretComponent from '@/components/SecretComponent.vue'

export default {
  name: 'HomeView',
  components: {
    SecretComponent
  }
}
</script>

<style>
</style>
