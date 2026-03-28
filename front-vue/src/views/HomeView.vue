<template>
  <div class="text-center py-5">
    <!-- Hero -->
    <div class="mb-4">
      <i class="bi bi-heart-pulse-fill text-primary" style="font-size:4rem;"></i>
    </div>
    <h1 class="fw-bold mb-3">Gestion Med <span class="text-primary">× Vue 3</span></h1>
    <p class="lead text-muted mb-4">
      Application de réservation de services médicaux.<br>
      Front-end Vue 3 qui consomme l'API Laravel.
    </p>

    <div class="d-flex justify-content-center gap-3 flex-wrap">
      <RouterLink to="/services" class="btn btn-primary btn-lg rounded-pill px-4">
        <i class="bi bi-grid me-2"></i>Voir les services
      </RouterLink>
      <RouterLink v-if="!isLoggedIn" to="/register"
                  class="btn btn-outline-primary btn-lg rounded-pill px-4">
        <i class="bi bi-person-plus me-2"></i>S'inscrire
      </RouterLink>
      <RouterLink v-else to="/mes-reservations"
                  class="btn btn-success btn-lg rounded-pill px-4">
        <i class="bi bi-calendar-check me-2"></i>Mes réservations
      </RouterLink>
    </div>

    <!-- Info stack -->
    <div class="row justify-content-center mt-5 g-3">
      <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
          <i class="bi bi-server text-primary fs-2 mb-2"></i>
          <div class="fw-bold">API Laravel 11</div>
          <div class="text-muted small">http://localhost:8000</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
          <i class="bi bi-shield-lock text-success fs-2 mb-2"></i>
          <div class="fw-bold">Sanctum Bearer</div>
          <div class="text-muted small">Token en localStorage</div>
        </div>
      </div>
      <div class="col-md-3">
        <div class="card border-0 shadow-sm rounded-4 p-3 text-center">
          <i class="bi bi-arrow-left-right text-warning fs-2 mb-2"></i>
          <div class="fw-bold">Axios + Proxy Vite</div>
          <div class="text-muted small">http://localhost:5173</div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { useAuth } from '../composables/useAuth'
const { isLoggedIn } = useAuth()
</script>
