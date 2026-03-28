<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthApiController;
use App\Http\Controllers\Api\V1\ServiceApiController;
use App\Http\Controllers\Api\V1\ReservationApiController;
use App\Http\Controllers\Api\V1\AdminApiController;

/*
|--------------------------------------------------------------------------
| API v1 — Système de Réservation de Services Médicaux
|--------------------------------------------------------------------------
|
| Tester avec Postman :
|   Base URL : http://localhost:8000/api/v1
|   Header   : Accept: application/json
|   Auth     : Bearer {token} (après login)
|
*/

Route::prefix('v1')->group(function () {

    /* --------------------------------------------------
     | Routes publiques (sans authentification)
     --------------------------------------------------*/

    // Liste des services actifs
    Route::get('/services', [ServiceApiController::class, 'index']);
    Route::get('/services/{id}', [ServiceApiController::class, 'show']);

    /* --------------------------------------------------
     | Authentification
     --------------------------------------------------*/
    Route::post('/register', [AuthApiController::class, 'register']);
    Route::post('/login',    [AuthApiController::class, 'login']);

    /* --------------------------------------------------
     | Routes protégées (token Sanctum requis)
     --------------------------------------------------*/
    Route::middleware('auth:sanctum')->group(function () {

        // Déconnexion
        Route::post('/logout', [AuthApiController::class, 'logout']);

        // Infos utilisateur connecté
        Route::get('/me', [AuthApiController::class, 'me']);

        /* --- Patient --- */
        Route::middleware('role:patient')->group(function () {
            Route::get('/reservations',           [ReservationApiController::class, 'myReservations']);
            Route::post('/reservations',          [ReservationApiController::class, 'store']);
            Route::post('/reservations/{id}/cancel', [ReservationApiController::class, 'cancel']);
        });

        /* --- Médecin --- */
        Route::middleware('role:medecin')->group(function () {
            Route::get('/medecin/services',    [ServiceApiController::class, 'myServices']);
            Route::get('/medecin/reservations', [ReservationApiController::class, 'medecinReservations']);
            Route::post('/medecin/reservations/{id}/update-status', [ReservationApiController::class, 'updateStatus']);
        });

        /* --- Admin --- */
        Route::middleware('role:admin')->group(function () {
            // Services CRUD
            Route::get('/admin/services',             [AdminApiController::class, 'servicesIndex']);
            Route::post('/admin/services',            [AdminApiController::class, 'servicesStore']);
            Route::put('/admin/services/{id}',        [AdminApiController::class, 'servicesUpdate']);
            Route::delete('/admin/services/{id}',     [AdminApiController::class, 'servicesDestroy']);
            Route::post('/admin/services/{id}/assign',[AdminApiController::class, 'servicesAssign']);

            // Réservations
            Route::get('/admin/reservations',              [AdminApiController::class, 'reservationsIndex']);
            Route::post('/admin/reservations/{id}/cancel', [AdminApiController::class, 'reservationsCancel']);

            // Utilisateurs
            Route::get('/admin/users',                  [AdminApiController::class, 'usersIndex']);
            Route::post('/admin/users/{id}/set-role',   [AdminApiController::class, 'usersSetRole']);
            Route::post('/admin/users/{id}/toggle',     [AdminApiController::class, 'usersToggle']);
        });
    });
});
