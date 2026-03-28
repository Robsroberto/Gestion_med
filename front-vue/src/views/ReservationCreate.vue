<template>
  <div class="row justify-content-center">
    <div class="col-lg-6 col-md-8">

      <div class="d-flex align-items-center justify-content-between mb-4">
        <h2 class="fw-bold text-primary mb-0">
          <i class="bi bi-calendar-plus me-2"></i>Nouvelle réservation
        </h2>
        <RouterLink to="/services" class="btn btn-outline-secondary btn-sm rounded-pill">
          <i class="bi bi-arrow-left me-1"></i>Retour
        </RouterLink>
      </div>

      <!-- Chargement du service -->
      <div v-if="chargement" class="text-center py-4">
        <div class="spinner-border text-primary"></div>
      </div>

      <template v-else-if="service">
        <!-- Récap service -->
        <div class="card border-0 shadow-sm rounded-4 mb-4"
             style="border-left:4px solid #4e73df !important;">
          <div class="card-body py-3 d-flex align-items-center">
            <div class="rounded-circle d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                 style="width:48px;height:48px;background:linear-gradient(135deg,#4e73df,#224abe);">
              <i class="bi bi-heart-pulse text-white"></i>
            </div>
            <div class="flex-grow-1">
              <div class="fw-bold text-primary h5 mb-0">{{ service.titre }}</div>
              <small class="text-muted">
                <i class="bi bi-clock me-1"></i>{{ service.duree }} min
                <span v-if="service.medecin">
                  &nbsp;•&nbsp;<i class="bi bi-person-badge me-1"></i>Dr. {{ service.medecin.name }}
                </span>
              </small>
            </div>
            <span class="badge rounded-pill px-3 py-2 fw-bold"
                  style="background:linear-gradient(135deg,#1cc88a,#13855c);color:#fff;">
              {{ formatPrix(service.prix) }} FCFA
            </span>
          </div>
        </div>

        <!-- Formulaire -->
        <div class="card border-0 shadow rounded-4">
          <div class="card-header border-0 py-3 px-4 rounded-top-4"
               style="background:linear-gradient(135deg,#4e73df,#36b9cc);">
            <h5 class="mb-0 text-white fw-bold">
              <i class="bi bi-calendar-check me-2"></i>Choisissez votre créneau
            </h5>
          </div>
          <div class="card-body p-4">
            <!-- Erreurs -->
            <div v-if="erreur" class="alert alert-danger py-2 small">
              <i class="bi bi-exclamation-circle me-1"></i>{{ erreur }}
            </div>
            <div v-if="erreurs" class="alert alert-warning py-2 small">
              <ul class="mb-0 ps-3">
                <li v-for="(msgs, champ) in erreurs" :key="champ">{{ msgs[0] }}</li>
              </ul>
            </div>

            <form @submit.prevent="handleSubmit">
              <div class="mb-3">
                <label class="form-label fw-semibold">
                  <i class="bi bi-calendar3 me-1 text-primary"></i>Date de réservation
                </label>
                <input v-model="form.date_reservation" type="date"
                       class="form-control rounded-3" :min="today" required />
              </div>

              <div class="mb-3">
                <label class="form-label fw-semibold">
                  <i class="bi bi-clock me-1 text-info"></i>Heure
                </label>
                <input v-model="form.heure_reservation" type="time"
                       class="form-control rounded-3" required />
              </div>

              <div class="mb-4">
                <label class="form-label fw-semibold">
                  <i class="bi bi-chat-left-text me-1 text-warning"></i>
                  Commentaire <small class="text-muted fw-normal">(optionnel)</small>
                </label>
                <textarea v-model="form.commentaire" class="form-control rounded-3" rows="3"
                          placeholder="Symptômes, motif de la consultation…"></textarea>
              </div>

              <div class="d-flex justify-content-between">
                <RouterLink to="/services" class="btn btn-outline-secondary rounded-pill px-4">
                  Annuler
                </RouterLink>
                <button type="submit" class="btn btn-primary rounded-pill px-4 fw-bold"
                        :disabled="envoi">
                  <span v-if="envoi">
                    <span class="spinner-border spinner-border-sm me-2"></span>Envoi…
                  </span>
                  <span v-else>
                    <i class="bi bi-check-circle me-2"></i>Confirmer
                  </span>
                </button>
              </div>
            </form>
          </div>
        </div>
      </template>
    </div>
  </div>
</template>

<script setup>
import { ref, onMounted, inject } from 'vue'
import { useRoute, useRouter }    from 'vue-router'
import api from '../services/api'

const route       = useRoute()
const router      = useRouter()
const showMessage = inject('showMessage')

const today      = new Date().toISOString().split('T')[0]
const service    = ref(null)
const chargement = ref(true)
const envoi      = ref(false)
const erreur     = ref(null)
const erreurs    = ref(null)

const form = ref({
  date_reservation:  '',
  heure_reservation: '',
  commentaire:       '',
})

onMounted(async () => {
  try {
    const { data } = await api.get(`/services/${route.params.id}`)
    service.value = data.data ?? data
  } catch {
    erreur.value = 'Service introuvable.'
  } finally {
    chargement.value = false
  }
})

async function handleSubmit() {
  erreur.value  = null
  erreurs.value = null
  envoi.value   = true
  try {
    await api.post('/reservations', {
      service_id:        route.params.id,
      date_reservation:  form.value.date_reservation,
      heure_reservation: form.value.heure_reservation,
      commentaire:       form.value.commentaire,
    })
    showMessage('Réservation confirmée ! Vous pouvez la suivre dans "Mes réservations".')
    router.push('/mes-reservations')
  } catch (e) {
    if (e.response?.status === 422) {
      erreurs.value = e.response.data.errors
    } else {
      erreur.value = e.response?.data?.message || 'Erreur lors de la réservation.'
    }
  } finally {
    envoi.value = false
  }
}

function formatPrix(n) {
  return Number(n).toLocaleString('fr-FR')
}
</script>
