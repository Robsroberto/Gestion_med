/**
 * router/index.js
 * ─────────────────────────────────────────────────────────
 * Configuration de Vue Router 4.
 *
 * - Routes publiques : /, /services, /services/:id, /login, /register
 * - Routes protégées (meta.requiresAuth) : /mes-reservations, /reserver/:id
 * - Navigation guard : redirige vers /login si non connecté
 */

import { createRouter, createWebHistory } from 'vue-router'

// Importation des vues (lazy loading)
const HomeView          = () => import('../views/HomeView.vue')
const LoginView         = () => import('../views/LoginView.vue')
const RegisterView      = () => import('../views/RegisterView.vue')
const ServicesView      = () => import('../views/ServicesView.vue')
const ServiceDetail     = () => import('../views/ServiceDetail.vue')
const ReservationCreate = () => import('../views/ReservationCreate.vue')
const MesReservations   = () => import('../views/MesReservations.vue')

const routes = [
  {
    path: '/',
    name: 'home',
    component: HomeView,
  },
  {
    path: '/login',
    name: 'login',
    component: LoginView,
    meta: { guestOnly: true },   // redirige si déjà connecté
  },
  {
    path: '/register',
    name: 'register',
    component: RegisterView,
    meta: { guestOnly: true },
  },
  {
    path: '/services',
    name: 'services',
    component: ServicesView,
  },
  {
    path: '/services/:id',
    name: 'service-detail',
    component: ServiceDetail,
  },
  {
    path: '/reserver/:id',
    name: 'reserver',
    component: ReservationCreate,
    meta: { requiresAuth: true, role: 'patient' },
  },
  {
    path: '/mes-reservations',
    name: 'mes-reservations',
    component: MesReservations,
    meta: { requiresAuth: true, role: 'patient' },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
  // Revenir en haut de page à chaque navigation
  scrollBehavior: () => ({ top: 0 }),
})

// ── Navigation Guard ───────────────────────────────────────
router.beforeEach((to) => {
  const token = localStorage.getItem('token')
  const user  = JSON.parse(localStorage.getItem('user') || 'null')

  // Route réservée aux invités (login/register) → rediriger si connecté
  if (to.meta.guestOnly && token) {
    return { name: 'services' }
  }

  // Route protégée → rediriger si non connecté
  if (to.meta.requiresAuth && !token) {
    return { name: 'login', query: { redirect: to.fullPath } }
  }

  // Route avec restriction de rôle
  if (to.meta.role && user?.role !== to.meta.role) {
    return { name: 'home' }
  }
})

export default router
