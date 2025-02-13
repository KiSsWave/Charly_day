import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import CreationBesoin from "../views/CreationBesoin.vue";

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/creation-besoin',
      name: 'creation-besoin',
      component: CreationBesoin,
    }
  ],
})

export default router
