<template>
  <div>
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><RouterLink to="/">Accueil</RouterLink></li>
        <li class="breadcrumb-item"><RouterLink to="/services">Services</RouterLink></li>
        <li class="breadcrumb-item active">Détail</li>
      </ol>
    </nav>

    <!-- Chargement -->
    <div v-if="chargement" class="text-center py-5">
      <div class="spinner-border text-primary"></div>
    </div>

    <!-- Erreur -->
    <div v-else-if="erreur" class="alert alert-danger">{{ erreur }}</div>

    <!-- Contenu -->
    <div v-else-if="service" class="row justify-content-center">
      <div class="col-lg-7">
        <div class="card border-0 shadow rounded-4 overflow-hidden">
          <!-- Header -->
          <div class="px-4 py-4 d-flex align-items-center gap-3"
               style="background:linear-gradient(135deg,#4e73df,#36b9cc);">
            <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                 style="width:56px;height:56px;background:rgba(255,255,255,.2);">
              <i class="bi bi-heart-pulse text-white fs-4"></i>
            </div>
            <div>
              <h4 class="mb-0 text-white fw-bold">{{ service.titre }}</h4>
              <small class="text-white opacity-75">Détail du service</small>
            </div>
          </div>

          <div class="card-body p-4">
            <p class="lead text-muted mb-4">{{ service.description }}</p>

            <!-- Infos clés -->
            <div class="row g-3 mb-4">
              <div class="col-md-4">
                <div class="p-3 text-center rounded-4" style="background:#f0f7f0;">
                  <i class="bi bi-tag-fill fs-3 mb-2 d-block text-success"></i>
                  <div class="fw-bold fs-5">{{ formatPrix(service.prix) }} FCFA</div>
                  <small class="text-muted">Tarif</small>
                </div>
              </div>
              <div class="col-md-4">
                <div class="p-3 text-center rounded-4" style="background:#e8f6fd;">
                  <i class="bi bi-clock-fill fs-3 mb-2 d-block" style="color:#36b9cc;"></i>
                  <div class="fw-bold fs-5">{{ service.duree }} min</div>
                  <small class="text-muted">Durée</small>
                </div>
              </div>
              <div class="col-md-4">
                <div class="p-3 text-center rounded-4" style="background:#eef2ff;">
                  <i class="bi bi-person-badge-fill fs-3 mb-2 d-block text-primary"></i>
                  <div class="fw-bold">
                    {{ service.medecin ? 'Dr. ' + service.medecin.name : 'Non assigné' }}
                  </div>
                  <small class="text-muted">Médecin</small>
                </div>
              </div>
            </div>
          </div>

          <div class="card-footer bg-light border-0 px-4 py-3
                      d-flex justify-content-between align-items-center">
            <RouterLink to="/services" class="btn btn-outline-secondary rounded-pill px-4">
              <i class="bi bi-arrow-left me-2"></i>Retour
            </RouterLink>
            <template v-if="isPatient">
              <RouterLink :to="`/reserver/${service.id}`"
                          class="btn btn-primary rounded-pill px-4 fw-bold">
                <i class="bi bi-calendar-plus me-2"></i>Réserver
              </RouterLink>
            </template>
            <template v-else-if="!isLoggedIn">
              <RouterLink to="/login" class="btn btn-primary rounded-pill px-4 fw-bold">
                <i class="bi bi-box-arrow-in-right me-2"></i>Connexion pour réserver
              </RouterLink>
            </template>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, computed, onMounted } from 'vue'
import { useRoute } from 'vue-router'
import api from '../services/api'
import { useAuth } from '../composables/useAuth'

const route = useRoute()
const { user, isLoggedIn } = useAuth()
const isPatient = computed(() => user.user?.role === 'patient')

const service    = ref(null)
const chargement = ref(true)
const erreur     = ref(null)

onMounted(async () => {
  try {
    const { data } = await api.get(`/services/${route.params.id}`)
    service.value = data.data ?? data
  } catch (e) {
    erreur.value = 'Service introuvable.'
  } finally {
    chargement.value = false
  }
})

function formatPrix(n) {
  return Number(n).toLocaleString('fr-FR')
}
</script>
