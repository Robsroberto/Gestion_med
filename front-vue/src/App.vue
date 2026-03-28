<template>
  <div>
    <!-- ══ NAVBAR ══════════════════════════════════════════ -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm">
      <div class="container">
        <RouterLink class="navbar-brand fw-bold" to="/">
          <i class="bi bi-hospital me-2"></i>Gestion Med
        </RouterLink>

        <button class="navbar-toggler border-0" type="button"
                data-bs-toggle="collapse" data-bs-target="#navMenu">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navMenu">
          <ul class="navbar-nav me-auto">
            <li class="nav-item">
              <RouterLink class="nav-link" to="/services">
                <i class="bi bi-grid me-1"></i>Services
              </RouterLink>
            </li>
          </ul>

          <ul class="navbar-nav ms-auto align-items-center gap-2">
            <!-- Non connecté -->
            <template v-if="!isLoggedIn">
              <li class="nav-item">
                <RouterLink class="nav-link" to="/login">Connexion</RouterLink>
              </li>
              <li class="nav-item">
                <RouterLink class="btn btn-light btn-sm rounded-pill px-3 fw-bold text-primary"
                            to="/register">
                  <i class="bi bi-person-plus me-1"></i>S'inscrire
                </RouterLink>
              </li>
            </template>

            <!-- Connecté -->
            <template v-else>
              <li class="nav-item" v-if="user.user?.role === 'patient'">
                <RouterLink class="nav-link" to="/mes-reservations">
                  <i class="bi bi-calendar-check me-1"></i>Mes réservations
                </RouterLink>
              </li>
              <li class="nav-item">
                <span class="nav-link text-white-50 small">
                  <i class="bi bi-person-circle me-1"></i>{{ user.user?.name }}
                </span>
              </li>
              <li class="nav-item">
                <button class="btn btn-outline-light btn-sm rounded-pill px-3"
                        @click="handleLogout">
                  <i class="bi bi-box-arrow-right me-1"></i>Déconnexion
                </button>
              </li>
            </template>
          </ul>
        </div>
      </div>
    </nav>

    <!-- ══ ALERTES GLOBALES ════════════════════════════════ -->
    <div class="container mt-3" v-if="globalMessage">
      <div :class="`alert alert-${globalType} alert-dismissible fade show`">
        {{ globalMessage }}
        <button type="button" class="btn-close" @click="globalMessage = null"></button>
      </div>
    </div>

    <!-- ══ VUE ACTIVE (router-view) ═══════════════════════ -->
    <main class="container py-4">
      <RouterView />
    </main>

    <!-- ══ FOOTER ══════════════════════════════════════════ -->
    <footer class="text-center py-3 mt-5 border-top text-muted small">
      &copy; {{ new Date().getFullYear() }} Gestion Med —
      <span class="text-primary">API Laravel 11</span> consommée par
      <span class="text-success">Vue 3</span>
    </footer>
  </div>
</template>

<script setup>
import { ref, provide } from 'vue'
import { useRouter } from 'vue-router'
import { useAuth } from './composables/useAuth'

const router = useRouter()
const { user, isLoggedIn, logout } = useAuth()

// Message flash global (partagé avec les vues via provide)
const globalMessage = ref(null)
const globalType    = ref('success')

function showMessage(msg, type = 'success') {
  globalMessage.value = msg
  globalType.value    = type
  setTimeout(() => { globalMessage.value = null }, 4000)
}

// Rendre showMessage disponible dans toutes les vues enfants
provide('showMessage', showMessage)

async function handleLogout() {
  await logout()
  router.push('/login')
}
</script>

<style>
body { background: #f8f9fc; font-family: 'Segoe UI', sans-serif; }
.navbar-brand { font-size: 1.25rem; }
footer { background: #fff; }
</style>
