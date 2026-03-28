<template>
  <div class="row justify-content-center">
    <div class="col-md-5 col-lg-4">
      <div class="card border-0 shadow rounded-4">

        <!-- En-tête -->
        <div class="card-header border-0 text-center py-4 rounded-top-4"
             style="background:linear-gradient(135deg,#4e73df,#36b9cc);">
          <i class="bi bi-person-lock text-white fs-1"></i>
          <h4 class="text-white fw-bold mt-2 mb-0">Connexion</h4>
        </div>

        <div class="card-body p-4">
          <!-- Erreur globale -->
          <div v-if="erreur" class="alert alert-danger py-2 small">
            <i class="bi bi-exclamation-circle me-1"></i>{{ erreur }}
          </div>

          <form @submit.prevent="handleLogin">
            <!-- Email -->
            <div class="mb-3">
              <label class="form-label fw-semibold">
                <i class="bi bi-envelope me-1 text-primary"></i>Email
              </label>
              <input v-model="form.email" type="email" class="form-control rounded-3"
                     placeholder="votre@email.com" required autofocus />
            </div>

            <!-- Mot de passe -->
            <div class="mb-4">
              <label class="form-label fw-semibold">
                <i class="bi bi-lock me-1 text-primary"></i>Mot de passe
              </label>
              <input v-model="form.password" type="password" class="form-control rounded-3"
                     placeholder="••••••••" required />
            </div>

            <!-- Bouton -->
            <button type="submit" class="btn btn-primary w-100 rounded-pill fw-bold py-2"
                    :disabled="chargement">
              <span v-if="chargement">
                <span class="spinner-border spinner-border-sm me-2"></span>Connexion…
              </span>
              <span v-else>
                <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
              </span>
            </button>
          </form>
        </div>

        <div class="card-footer text-center bg-light rounded-bottom-4 py-3">
          <small class="text-muted">
            Pas encore de compte ?
            <RouterLink to="/register" class="fw-bold">S'inscrire</RouterLink>
          </small>
        </div>
      </div>

      <!-- Comptes de démo -->
      <div class="card border-0 shadow-sm rounded-4 mt-3">
        <div class="card-body p-3">
          <p class="fw-bold small mb-2 text-muted text-uppercase">
            <i class="bi bi-info-circle me-1"></i>Comptes de démo
          </p>
          <div v-for="compte in comptes" :key="compte.email"
               class="d-flex justify-content-between align-items-center py-1 border-bottom">
            <div>
              <span :class="`badge bg-${compte.couleur} me-2`">{{ compte.role }}</span>
              <small class="text-muted">{{ compte.email }}</small>
            </div>
            <button class="btn btn-sm btn-outline-secondary rounded-pill"
                    @click="remplirCompte(compte)">
              Utiliser
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
import { ref, inject } from 'vue'
import { useRouter } from 'vue-router'
import { useAuth } from '../composables/useAuth'

const router      = useRouter()
const { login }   = useAuth()
const showMessage = inject('showMessage')

const form = ref({ email: '', password: '' })
const erreur     = ref(null)
const chargement = ref(false)

const comptes = [
  { role: 'Admin',    email: 'admin@gestionmed.ci',      password: 'password', couleur: 'danger'  },
  { role: 'Médecin',  email: 'dr.konan@gestionmed.ci',   password: 'password', couleur: 'info'    },
  { role: 'Médecin',  email: 'dr.bamba@gestionmed.ci',   password: 'password', couleur: 'info'    },
  { role: 'Patient',  email: 'patient@gestionmed.ci',    password: 'password', couleur: 'success' },
  { role: 'Patient',  email: 'patient2@gestionmed.ci',   password: 'password', couleur: 'success' },
]

function remplirCompte(c) {
  form.value.email    = c.email
  form.value.password = c.password
}

async function handleLogin() {
  erreur.value     = null
  chargement.value = true
  try {
    const data = await login(form.value.email, form.value.password)
    showMessage(`Bienvenue, ${data.user.name} !`)
    // Redirection selon le rôle
    const role = data.user.role
    if (role === 'patient')  router.push('/mes-reservations')
    else                     router.push('/services')
  } catch (e) {
    erreur.value = e.response?.data?.message || 'Identifiants incorrects.'
  } finally {
    chargement.value = false
  }
}
</script>
