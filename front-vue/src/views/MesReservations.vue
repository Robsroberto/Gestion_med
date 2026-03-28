<template>
  <div>
    <div class="d-flex align-items-center justify-content-between mb-4">
      <div>
        <h2 class="fw-bold text-primary mb-1">
          <i class="bi bi-calendar-check me-2"></i>Mes réservations
        </h2>
        <p class="text-muted mb-0">Historique de toutes vos réservations.</p>
      </div>
      <RouterLink to="/services" class="btn btn-primary rounded-pill px-4">
        <i class="bi bi-plus me-1"></i>Nouvelle
      </RouterLink>
    </div>

    <!-- Chargement -->
    <div v-if="chargement" class="text-center py-5">
      <div class="spinner-border text-primary"></div>
      <p class="text-muted mt-2">Chargement…</p>
    </div>

    <!-- Vide -->
    <div v-else-if="reservations.length === 0" class="text-center py-5">
      <i class="bi bi-calendar-x text-muted" style="font-size:4rem;"></i>
      <h5 class="text-muted mt-3">Aucune réservation</h5>
      <p class="text-muted small">Consultez nos services pour prendre votre premier rendez-vous.</p>
      <RouterLink to="/services" class="btn btn-primary rounded-pill px-4 mt-2">
        <i class="bi bi-grid me-2"></i>Voir les services
      </RouterLink>
    </div>

    <!-- Liste des réservations -->
    <div v-else class="card border-0 shadow rounded-4">
      <div class="card-header bg-white border-0 d-flex align-items-center justify-content-between py-3 px-4">
        <h6 class="fw-bold text-primary mb-0">
          <i class="bi bi-list-ul me-2"></i>Toutes mes réservations
        </h6>
        <span class="badge bg-primary rounded-pill">{{ reservations.length }}</span>
      </div>
      <div class="card-body p-0">
        <div class="table-responsive">
          <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
              <tr>
                <th class="ps-4">Service</th>
                <th>Date</th>
                <th>Heure</th>
                <th>Statut</th>
                <th class="text-center">Action</th>
              </tr>
            </thead>
            <tbody>
              <tr v-for="r in reservations" :key="r.id">
                <td class="ps-4">
                  <div class="d-flex align-items-center gap-3">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0"
                         style="width:40px;height:40px;background:linear-gradient(135deg,#4e73df,#224abe);">
                      <i class="bi bi-heart-pulse text-white" style="font-size:.75rem;"></i>
                    </div>
                    <div>
                      <div class="fw-bold">{{ r.service?.titre ?? 'N/A' }}</div>
                    </div>
                  </div>
                </td>
                <td>
                  <i class="bi bi-calendar3 text-primary me-1"></i>
                  {{ formatDate(r.date_reservation) }}
                </td>
                <td>
                  <i class="bi bi-clock text-info me-1"></i>
                  {{ r.heure_reservation }}
                </td>
                <td>
                  <span :class="`badge rounded-pill px-3 py-2 ${badgeClass(r.statut)}`">
                    {{ labelStatut(r.statut) }}
                  </span>
                </td>
                <td class="text-center">
                  <button v-if="r.statut === 'en_attente'"
                          class="btn btn-outline-danger btn-sm rounded-pill"
                          :disabled="annulationId === r.id"
                          @click="annuler(r.id)">
                    <span v-if="annulationId === r.id">
                      <span class="spinner-border spinner-border-sm me-1"></span>
                    </span>
                    <span v-else>
                      <i class="bi bi-x-circle me-1"></i>Annuler
                    </span>
                  </button>
                  <span v-else class="text-muted small">—</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, inject } from 'vue'
import api from '../services/api'

const showMessage   = inject('showMessage')
const reservations  = ref([])
const chargement    = ref(true)
const annulationId  = ref(null)

onMounted(async () => {
  await charger()
})

async function charger() {
  chargement.value = true
  try {
    const { data } = await api.get('/reservations')
    reservations.value = data.data ?? data
  } finally {
    chargement.value = false
  }
}

async function annuler(id) {
  if (!confirm('Annuler cette réservation ?')) return
  annulationId.value = id
  try {
    await api.post(`/reservations/${id}/cancel`)
    showMessage('Réservation annulée.')
    await charger()
  } catch (e) {
    showMessage(e.response?.data?.message || 'Erreur.', 'danger')
  } finally {
    annulationId.value = null
  }
}

function formatDate(d) {
  return new Date(d).toLocaleDateString('fr-FR')
}

function labelStatut(s) {
  return { en_attente: 'En attente', confirmee: 'Confirmée',
           annulee: 'Annulée', effectuee: 'Effectuée' }[s] ?? s
}

function badgeClass(s) {
  return { en_attente: 'bg-warning text-dark', confirmee: 'bg-success',
           annulee: 'bg-danger', effectuee: 'bg-info' }[s] ?? 'bg-secondary'
}
</script>
