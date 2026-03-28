/**
 * composables/useAuth.js
 * ─────────────────────────────────────────────────────────
 * Gestion de l'état d'authentification (token + user).
 * Utilise localStorage pour persister la session.
 *
 * Exposé : { user, isLoggedIn, login, register, logout }
 */

import { reactive, computed } from 'vue'
import api from '../services/api'

// État global réactif (partagé entre tous les composants)
const state = reactive({
  user:  JSON.parse(localStorage.getItem('user'))  || null,
  token: localStorage.getItem('token') || null,
})

export function useAuth() {

  const isLoggedIn = computed(() => !!state.token)

  // ── Connexion ──────────────────────────────────────────
  async function login(email, password) {
    const { data } = await api.post('/login', { email, password })
    _saveSession(data)
    return data
  }

  // ── Inscription ────────────────────────────────────────
  async function register(name, email, password, password_confirmation) {
    const { data } = await api.post('/register', {
      name, email, password, password_confirmation,
    })
    _saveSession(data)
    return data
  }

  // ── Déconnexion ────────────────────────────────────────
  async function logout() {
    try {
      await api.post('/logout')
    } catch (_) {
      // même si le serveur renvoie une erreur, on déconnecte localement
    } finally {
      _clearSession()
    }
  }

  // ── Helpers privés ────────────────────────────────────
  function _saveSession(data) {
    state.token = data.token
    state.user  = data.user
    localStorage.setItem('token', data.token)
    localStorage.setItem('user',  JSON.stringify(data.user))
  }

  function _clearSession() {
    state.token = null
    state.user  = null
    localStorage.removeItem('token')
    localStorage.removeItem('user')
  }

  return { user: state, isLoggedIn, login, register, logout }
}
