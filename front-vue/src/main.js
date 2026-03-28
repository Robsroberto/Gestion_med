/**
 * main.js — Point d'entrée de l'application Vue 3
 */

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

// Bootstrap 5 (CSS + JS)
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap'
import 'bootstrap-icons/font/bootstrap-icons.css'

createApp(App)
  .use(router)
  .mount('#app')
