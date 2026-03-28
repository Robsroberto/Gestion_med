# 🏥 Gestion Med — Système de Réservation de Services Médicaux

> Projet fil rouge — TechnoWeb Back-End | Laravel 11 + API REST v1 (Sanctum)

---

## 📋 Description

**Gestion Med** est une application web de gestion de rendez-vous médicaux développée avec **Laravel 11**.

Elle intègre :
- Un **front-end complet** avec template Bootstrap 5 (vitrine, espace patient, médecin, admin)
- Une **API REST v1** complète, sécurisée avec **Laravel Sanctum**, testable avec Postman

### Rôles disponibles

| Rôle | Accès |
|---|---|
| **Patient** | Voir les services, réserver un créneau, annuler ses réservations |
| **Médecin** | Voir ses services assignés, gérer les statuts des réservations |
| **Admin** | CRUD services, gestion des utilisateurs et de toutes les réservations |

---

## ⚙️ Stack technique

| Technologie | Usage |
|---|---|
| **Laravel 11** | Framework PHP back-end |
| **MySQL** | Base de données relationnelle |
| **Laravel Sanctum** | Authentification API par token |
| **Bootstrap 5** | UI front-end (pages publiques) |
| **SB Admin 2** | Template dashboard (Bootstrap 4) |
| **Font Awesome 6** | Icônes |

---

## 🚀 Installation — Démarrage rapide

### Prérequis
- PHP >= 8.2
- Composer
- MySQL
- Node.js & npm

### Étapes

```bash
# 1. Cloner le dépôt
git clone https://github.com/Robsroberto/Gestion_med.git
cd gestion-med

# 2. Installer les dépendances PHP
composer install

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 4. Configurer la base de données dans .env
#    DB_DATABASE=reservation_app
#    DB_USERNAME=root
#    DB_PASSWORD=

# 5. Créer la base de données MySQL
#    Depuis phpMyAdmin OU :
mysql -u root -e "CREATE DATABASE reservation_app CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 6. Lancer les migrations + données de démonstration
php artisan migrate:fresh --seed

# 7. Démarrer le serveur
php artisan serve
```

L'application est disponible sur **http://localhost:8000**

---

## 👤 Comptes de démonstration

Après `php artisan migrate:fresh --seed`, les comptes suivants sont disponibles :

| Rôle | Nom | Email | Mot de passe |
|---|---|---|---|
| Admin | Admin Principal | admin@gestionmed.ci | password |
| Médecin 1 | Dr. Konan Akissi | dr.konan@gestionmed.ci | password |
| Médecin 2 | Dr. Bamba Oumar | dr.bamba@gestionmed.ci | password |
| Patient 1 | Moussa Traoré | patient@gestionmed.ci | password |
| Patient 2 | Aminata Koné | patient2@gestionmed.ci | password |

---

## 🗂️ Structure du projet

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Api/V1/               ← Contrôleurs API REST
│   │   │   ├── AuthApiController.php
│   │   │   ├── ServiceApiController.php
│   │   │   ├── ReservationApiController.php
│   │   │   └── AdminApiController.php
│   │   ├── Admin/                ← Contrôleurs interface admin web
│   │   ├── AuthController.php
│   │   ├── DashboardController.php
│   │   ├── MedecinController.php
│   │   ├── ReservationController.php
│   │   └── ServiceController.php
│   └── Middleware/
│       └── RoleMiddleware.php    ← Contrôle d'accès par rôle
├── Models/
│   ├── User.php
│   ├── Service.php
│   └── Reservation.php
database/
├── migrations/
└── seeders/
    └── DemoSeeder.php
resources/views/
├── welcome.blade.php             ← Page vitrine (Bootstrap 5)
├── layouts/
│   ├── app.blade.php             ← Layout public (Bootstrap 5)
│   └── admin.blade.php           ← Layout dashboard (SB Admin 2)
├── auth/                         ← Login, Register
├── dashboard/                    ← Dashboards par rôle
├── admin/                        ← Gestion admin
├── medecin/                      ← Espace médecin
├── reservations/                 ← Espace patient
└── services/                     ← Catalogue services
routes/
├── web.php                       ← Routes front-end
└── api.php                       ← Routes API v1
postman_collection.json           ← Collection Postman prête à l'emploi
```

---

## 🌐 Routes Web

```
GET  /                           → Page vitrine
GET  /services                   → Liste des services (public)
GET  /services/{id}              → Détail d'un service (public)
GET  /login                      → Formulaire connexion
POST /login                      → Authentification
GET  /register                   → Formulaire inscription
POST /register                   → Création de compte
POST /logout                     → Déconnexion

── Patient (authentifié) ──
GET  /mes-reservations           → Mes réservations
GET  /reservation/{id}/create    → Formulaire de réservation
POST /reservation/store          → Enregistrer une réservation
POST /reservation/{id}/cancel    → Annuler une réservation

── Médecin (authentifié) ──
GET  /medecin/services           → Mes services assignés
GET  /medecin/reservations       → Réservations de mes patients
POST /medecin/reservations/{id}/update-status

── Admin (authentifié) ──
GET  /admin/services             → Gestion des services
GET  /admin/reservations         → Toutes les réservations
GET  /admin/users                → Gestion des utilisateurs
```

---

## 🔌 API REST v1

> **Base URL :** `http://localhost:8000/api/v1`
> **Header requis :** `Accept: application/json`
> **Authentification :** `Authorization: Bearer {token}` (obtenu après `/login`)

### Endpoints publics (sans token)

| Méthode | Endpoint | Description |
|---|---|---|
| `GET` | `/services` | Liste des services actifs |
| `GET` | `/services/{id}` | Détail d'un service |
| `POST` | `/register` | Inscription → retourne un token |
| `POST` | `/login` | Connexion → retourne un token |

### Authentifiés (tous rôles)

| Méthode | Endpoint | Description |
|---|---|---|
| `POST` | `/logout` | Déconnexion (invalide le token) |
| `GET` | `/me` | Infos de l'utilisateur connecté |

### Patient uniquement

| Méthode | Endpoint | Description |
|---|---|---|
| `GET` | `/reservations` | Mes réservations |
| `POST` | `/reservations` | Créer une réservation |
| `POST` | `/reservations/{id}/cancel` | Annuler une réservation |

### Médecin uniquement

| Méthode | Endpoint | Description |
|---|---|---|
| `GET` | `/medecin/services` | Mes services |
| `GET` | `/medecin/reservations` | Réservations de mes patients |
| `POST` | `/medecin/reservations/{id}/update-status` | Changer le statut |

### Admin uniquement

| Méthode | Endpoint | Description |
|---|---|---|
| `GET` | `/admin/services` | Tous les services |
| `POST` | `/admin/services` | Créer un service |
| `PUT` | `/admin/services/{id}` | Modifier un service |
| `DELETE` | `/admin/services/{id}` | Supprimer un service |
| `POST` | `/admin/services/{id}/assign` | Assigner un médecin |
| `GET` | `/admin/reservations` | Toutes les réservations |
| `POST` | `/admin/reservations/{id}/cancel` | Annuler |
| `GET` | `/admin/users` | Tous les utilisateurs |
| `POST` | `/admin/users/{id}/set-role` | Changer le rôle |
| `POST` | `/admin/users/{id}/toggle` | Activer / désactiver |

---

## 📬 Tester l'API avec Postman

### Étape 1 — Importer la collection

Importez le fichier **`postman_collection.json`** dans Postman
*(File → Import → sélectionner le fichier)*

### Étape 2 — Configurer la variable d'environnement

Créez un environnement Postman avec la variable :

| Variable | Valeur initiale |
|---|---|
| `base_url` | `http://localhost:8000/api/v1` |
| `token` | *(laissez vide, sera rempli après login)* |

### Étape 3 — Workflow de test

```
1. POST {{base_url}}/register   → Créer un compte
2. POST {{base_url}}/login      → Se connecter (copier le token)
3. Coller le token dans la variable d'environnement "token"
4. GET  {{base_url}}/services   → Tester sans auth
5. GET  {{base_url}}/me         → Tester avec auth
6. POST {{base_url}}/reservations → Réserver un service
7. GET  {{base_url}}/reservations → Voir mes réservations
8. POST {{base_url}}/logout      → Se déconnecter
```

### Exemples de requêtes

**Inscription :**
```json
POST /api/v1/register
{
    "name": "Jean Dupont",
    "email": "jean@exemple.com",
    "password": "password",
    "password_confirmation": "password"
}
```

**Réponse :**
```json
{
    "message": "Inscription réussie.",
    "user": { "id": 10, "name": "Jean Dupont", "email": "...", "role": "patient" },
    "token": "1|abc123..."
}
```

**Créer une réservation :**
```json
POST /api/v1/reservations
Authorization: Bearer 1|abc123...

{
    "service_id": 1,
    "date_reservation": "2026-04-15",
    "heure_reservation": "09:30",
    "commentaire": "Consultation de routine"
}
```

---

## 📊 Modèle de données

```
users
├── id, name, email, password
├── role  → admin | medecin | patient
└── timestamps

services
├── id, titre, description, prix, duree (minutes)
├── statut  → actif | inactif
├── medecin_id → users.id
└── timestamps

reservations
├── id
├── user_id    → users.id  (patient)
├── service_id → services.id
├── date_reservation, heure_reservation
├── statut  → en_attente | confirmee | annulee | effectuee
├── commentaire (nullable)
└── timestamps
```

---

## 🔐 Sécurité

- **Session** pour le front-end (Laravel Auth native)
- **Token Bearer** pour l'API (Laravel Sanctum)
- **`RoleMiddleware`** sur toutes les routes protégées
- **Validation** des données à chaque requête
- **Protection CSRF** sur tous les formulaires

---

## 📦 Commandes utiles

```bash
# Réinitialiser la BDD avec les données de démo
php artisan migrate:fresh --seed

# Lister toutes les routes
php artisan route:list

# Lister les routes API uniquement
php artisan route:list --path=api

# Vider les caches
php artisan cache:clear && php artisan config:clear && php artisan view:clear
```

---

## 🎓 Pour aller plus loin

Ce projet constitue la **base back-end** à consommer par un front-end JavaScript.

Prochaines étapes suggérées :
1. ✅ Tester toutes les routes API avec Postman
2. 🔑 Comprendre le token Bearer (Sanctum) et son cycle de vie
3. 🖥️ Créer un front-end (Vue 3 / React / Vanilla JS) qui consomme cette API
4. 💾 Gérer le token en `localStorage` côté client
5. 🔄 Gérer les états (`en_attente`, `confirmee`, etc.) dans l'UI

---

*Projet réalisé dans le cadre du cours TechnoWeb Back-End.*
