<template>
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card border-0 shadow rounded-4">

        <div class="card-header border-0 text-center py-4 rounded-top-4"
             style="background:linear-gradient(135deg,#1cc88a,#36b9cc);">
          <i class="bi bi-person-plus text-white fs-1"></i>
          <h4 class="text-white fw-bold mt-2 mb-0">Créer un compte</h4>
          <small class="text-white opacity-75">Vous serez inscrit comme patient</small>
        </div>

        <div class="card-body p-4">
          <div v-if="erreur" class="alert alert-danger py-2 small">
            <i class="bi bi-exclamation-circle me-1"></i>{{ erreur }}
          </div>
          <!-- Erreurs de validation champs -->
          <div v-if="erreurs" class="alert alert-warning py-2 small">
            <ul class="mb-0 ps-3">
              <li v-for="(msgs, champ) in erreurs" :key="champ">
                {{ msgs[0] }}
              </li>
            </ul>
          </div>

          <form @submit.prevent="handleRegister">
            <div class="mb-3">
              <label class="form-label fw-semibold">
                <i class="bi bi-person me-1 text-success"></i>Nom complet
              </label>
              <input v-model="form.name" type="text" class="form-control rounded-3"
                     placeholder="Jean Dupont" required />
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">
                <i class="bi bi-envelope me-1 text-success"></i>Email
              </label>
              <input v-model="form.email" type="email" class="form-control rounded-3"
                     placeholder="jean@exemple.com" required />
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">
                <i class="bi bi-lock me-1 text-success"></i>Mot de passe
              </label>
              <input v-model="form.password" type="password" class="form-control rounded-3"
                     placeholder="Minimum 6 caractères" required minlength="6" />
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold">
                <i class="bi bi-lock-fill me-1 text-success"></i>Confirmer le mot de passe
              </label>
              <input v-model="form.password_confirmation" type="password"
                     class="form-control rounded-3" placeholder="••••••••" required />
            </div>

            <button type="submit" class="btn btn-success w-100 rounded-pill fw-bold py-2"
                    :disabled="chargement">
              <span v-if="chargement">
                <span class="spinner-border spinner-border-sm me-2"></span>Inscription…
              </span>
              <span v-else>
                <i class="bi bi-check-circle me-2"></i>Créer mon compte
              </span>
            </button>
          </form>
        </div>

        <div class="card-footer text-center bg-light rounded-bottom-4 py-3">
          <small class="text-muted">
            Déjà un compte ?
            <RouterLink to="/login" class="fw-bold">Se connecter</RouterLink>
          </small>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, inject } from 'vue'
import { useRouter }    from 'vue-router'
import { useAuth }      from '../composables/useAuth'

const router        = useRouter()
const { register }  = useAuth()
const showMessage   = inject('showMessage')

const form = ref({
  name: '', email: '', password: '', password_confirmation: '',
})
const erreur     = ref(null)
const erreurs    = ref(null)   // erreurs de validation Laravel
const chargement = ref(false)

async function handleRegister() {
  erreur.value     = null
  erreurs.value    = null
  chargement.value = true
  try {
    const data = await register(
      form.value.name, form.value.email,
      form.value.password, form.value.password_confirmation
    )
    showMessage(`Bienvenue, ${data.user.name} ! Votre compte patient a été créé.`)
    router.push('/services')
  } catch (e) {
    if (e.response?.status === 422) {
      erreurs.value = e.response.data.errors
    } else {
      erreur.value = e.response?.data?.message || 'Erreur lors de l\'inscription.'
    }
  } finally {
    chargement.value = false
  }
}
</script>
