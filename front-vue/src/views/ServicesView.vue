<template>
  <div>
    <!-- En-tête -->
    <div class="d-flex align-items-center justify-content-between mb-4">
      <div>
        <h2 class="fw-bold text-primary mb-1">
          <i class="bi bi-grid me-2"></i>Services médicaux
        </h2>
        <p class="text-muted mb-0">Consultez nos services et réservez en ligne.</p>
      </div>
    </div>

    <!-- Chargement -->
    <div v-if="chargement" class="text-center py-5">
      <div class="spinner-border text-primary" role="status"></div>
      <p class="text-muted mt-2">Chargement des services…</p>
    </div>

    <!-- Erreur -->
    <div v-else-if="erreur" class="alert alert-danger">
      <i class="bi bi-exclamation-triangle me-2"></i>{{ erreur }}
    </div>

    <!-- Liste -->
    <div v-else-if="services.length > 0" class="row g-4">
      <div v-for="service in services" :key="service.id" class="col-md-6 col-lg-4">
        <div class="card h-100 border-0 shadow-sm rounded-4"
             style="transition:.25s;" @mouseenter="e => e.currentTarget.style.transform='translateY(-5px)'"
             @mouseleave="e => e.currentTarget.style.transform=''">

          <!-- Header coloré -->
          <div class="text-center py-4 rounded-top-4"
               style="background:linear-gradient(135deg,#4e73df,#36b9cc);">
            <i class="bi bi-heart-pulse text-white" style="font-size:2rem;"></i>
          </div>

          <div class="card-body d-flex flex-column p-4">
            <h5 class="fw-bold text-dark mb-1">{{ service.titre }}</h5>
            <p class="text-muted small flex-grow-1">{{ truncate(service.description, 90) }}</p>

            <!-- Médecin assigné -->
            <div v-if="service.medecin" class="d-flex align-items-center mb-3 p-2 bg-light rounded-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center me-2 flex-shrink-0"
                   style="width:34px;height:34px;background:linear-gradient(135deg,#4e73df,#224abe);">
                <i class="bi bi-person-badge text-white" style="font-size:.75rem;"></i>
              </div>
              <div>
                <div class="fw-bold text-dark" style="font-size:.85rem;">
                  Dr. {{ service.medecin.name }}
                </div>
                <div class="text-muted" style="font-size:.72rem;">Médecin assigné</div>
              </div>
            </div>

            <!-- Prix / Durée -->
            <div class="d-flex align-items-center justify-content-between mb-3">
              <span class="badge rounded-pill px-3 py-2 fw-bold"
                    style="background:linear-gradient(135deg,#1cc88a,#13855c);color:#fff;">
                {{ formatPrix(service.prix) }} FCFA
              </span>
              <span class="badge rounded-pill px-3 py-2 fw-semibold"
                    style="background:#e8f6fd;color:#36b9cc;">
                <i class="bi bi-clock me-1"></i>{{ service.duree }} min
              </span>
            </div>

            <!-- Actions -->
            <div class="d-flex gap-2 mt-auto">
              <RouterLink :to="`/services/${service.id}`"
                          class="btn btn-outline-primary btn-sm flex-fill rounded-pill">
                <i class="bi bi-eye me-1"></i>Détails
              </RouterLink>
              <template v-if="isPatient">
                <RouterLink :to="`/reserver/${service.id}`"
                            class="btn btn-primary btn-sm flex-fill rounded-pill">
                  <i class="bi bi-calendar-plus me-1"></i>Réserver
                </RouterLink>
              </template>
              <template v-else-if="!isLoggedIn">
                <RouterLink to="/login"
                            class="btn btn-primary btn-sm flex-fill rounded-pill">
                  <i class="bi bi-box-arrow-in-right me-1"></i>Réserver
                </RouterLink>
              </template>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Aucun service -->
    <div v-else class="text-center py-5 text-muted">
      <i class="bi bi-inbox fs-1 d-block mb-3"></i>
      Aucun service disponible pour le moment.
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, computed } from 'vue'
import api from '../services/api'
import { useAuth } from '../composables/useAuth'

const { user, isLoggedIn } = useAuth()
const isPatient = computed(() => user.user?.role === 'patient')

const services   = ref([])
const chargement = ref(true)
const erreur     = ref(null)

onMounted(async () => {
  try {
    const { data } = await api.get('/services')
    services.value = data.data ?? data
  } catch (e) {
    erreur.value = 'Impossible de charger les services.'
  } finally {
    chargement.value = false
  }
})

function truncate(str, len) {
  return str?.length > len ? str.slice(0, len) + '…' : str
}
function formatPrix(n) {
  return Number(n).toLocaleString('fr-FR')
}
</script>
