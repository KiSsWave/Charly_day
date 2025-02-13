import { createRouter, createWebHistory } from 'vue-router'
import HomeView from '../views/HomeView.vue'
import CreationBesoin from "../views/CreationBesoin.vue";
import AffichageBesoin from "../views/AffichageBesoin.vue";
import login from "../views/Login.vue";
import register from "../views/Register.vue";

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
    },
    {
      path: '/affichage-besoin',
      name: 'affichage-besoin',
      component: AffichageBesoin,
    },
    {
      path: '/login',
      name: 'login',
      component: login,
    },
    {
      path: '/register',
      name: 'register',
      component: register,
    },
  ],
})

export default router
