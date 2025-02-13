import { createRouter, createWebHistory } from 'vue-router';
import HomeView from '../views/HomeView.vue';
import CreationBesoin from "../views/CreationBesoin.vue";
import AffichageBesoin from "../views/AffichageBesoin.vue";
import login from "../views/Login.vue";
import register from "../views/Register.vue";
import ModifBesoin from '../views/ModifBesoin.vue';
import AdminView from '../views/AdminView.vue';
import AdminNeeds from '../views/AdminNeeds.vue';
import CreateEmployee from '../views/CreateEmployee.vue';
import ManageSkills from '../views/ManageSkills.vue';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    {
      path: '/',
      name: 'home',
      component: HomeView,
    },
    {
      path: '/need/new',
      name: 'creation-besoin',
      component: CreationBesoin,
    },
    {
      path: '/need/:id',
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
    {
      path: '/need/modif/:id',
      name: 'modification-besoin',
      component: ModifBesoin,
    },
    {
      path: '/admin',
      name: 'AdminView',
      component: AdminView,
      children: [
        {
          path: 'needs',
          name: 'ShowNeeds',
          component: AdminNeeds,
        },
        {
          path: 'employee',
          name: 'CreateEmployee',
          component: CreateEmployee,
        },
        {
          path: 'skills',
          name: 'ManageSkills',
          component: ManageSkills,
        },
      ],
    },
  ],
});

router.beforeEach((to, from, next) => {
  const role = parseInt(localStorage.getItem('role'), 10);

  console.log("🔍 Navigation vers :", to.path);
  console.log("👤 Rôle utilisateur :", role);

  // Si un utilisateur avec le rôle 3 (admin) veut aller hors de /admin, on le redirige
  if (role === 3 && !to.path.startsWith('/admin')) {
    return next('/admin');
  }

  // Si un non-admin essaie d'accéder à /admin ou une de ses sous-routes, on le redirige
  if (to.path.startsWith('/admin') && role !== 3) {
    return next('/');
  }

  next();
});


export default router;
