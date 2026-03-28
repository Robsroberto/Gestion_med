/**
 * services/api.js
 * ─────────────────────────────────────────────────────────
 * Instance Axios configurée pour l'API Gestion Med.
 *
 * - baseURL : /api/v1 (proxy Vite → http://localhost:8000)
 * - Intercepteur de requête : ajoute automatiquement le token Bearer
 * - Intercepteur de réponse : gère l'expiration du token (401)
 */

import axios from 'axios'
import router from '../router'

const api = axios.create({
  baseURL: '/api/v1',
  headers: {
    'Accept': 'application/json',
    'Content-Type': 'application/json',
  },
})

// ── Intercepteur REQUÊTE : injecter le token si présent ──
api.interceptors.request.use((config) => {
  const token = localStorage.getItem('token')
  if (token) {
    config.headers.Authorization = `Bearer ${token}`
  }
  return config
})

// ── Intercepteur RÉPONSE : rediriger si token expiré ──
api.interceptors.response.use(
  (response) => response,
  (error) => {
    if (error.response?.status === 401) {
      localStorage.removeItem('token')
      localStorage.removeItem('user')
      router.push('/login')
    }
    return Promise.reject(error)
  }
)

export default api
