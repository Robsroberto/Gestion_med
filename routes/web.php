<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers as C;
use App\Http\Controllers\Admin;

/* --------------------------------------------------
 | Routes publiques
 ---------------------------------------------------*/
Route::get('/', function () {
    $services = \App\Models\Service::with('medecin')
        ->where('statut', 'actif')
        ->take(6)
        ->get();
    $stats = [
        'services'     => \App\Models\Service::count(),
        'medecins'     => \App\Models\User::where('role', 'medecin')->count(),
        'patients'     => \App\Models\User::where('role', 'patient')->count(),
        'reservations' => \App\Models\Reservation::count(),
    ];
    return view('welcome', compact('services', 'stats'));
});

Route::get('/services', [C\ServiceController::class, 'index']);
Route::get('/services/{id}', [C\ServiceController::class, 'show']);

/* --------------------------------------------------
 | Routes Auth (login / register / logout)
 ---------------------------------------------------*/
Route::get('/login', [C\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [C\AuthController::class, 'login']);
Route::post('/logout', [C\AuthController::class, 'logout'])->middleware('auth')->name('logout');
Route::get('/register', [C\AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [C\AuthController::class, 'register']);

/* --------------------------------------------------
 | Tableau de bord général (redirige selon le rôle)
 ---------------------------------------------------*/
Route::get('/dashboard', [C\DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

/* --------------------------------------------------
 | Routes patient
 ---------------------------------------------------*/
Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/reservation/{service_id}/create', [C\ReservationController::class, 'create']);
    Route::post('/reservation/store', [C\ReservationController::class, 'store']);
    Route::get('/mes-reservations', [C\ReservationController::class, 'myReservations']);
    Route::post('/reservation/{id}/cancel', [C\ReservationController::class, 'cancel']);
});

/* --------------------------------------------------
 | Routes médecin
 ---------------------------------------------------*/
Route::middleware(['auth', 'role:medecin'])->group(function () {
    Route::get('/medecin/services', [C\MedecinController::class, 'services']);
    Route::get('/medecin/reservations', [C\MedecinController::class, 'reservations']);
    Route::post('/medecin/reservations/{id}/update-status', [C\MedecinController::class, 'updateStatus']);
});

/* --------------------------------------------------
 | Routes administrateur
 ---------------------------------------------------*/
Route::middleware(['auth', 'role:admin'])->group(function () {

    // Services
    Route::get('/admin/services', [Admin\AdminServiceController::class, 'index']);
    Route::get('/admin/services/create', [Admin\AdminServiceController::class, 'create']);
    Route::post('/admin/services/store', [Admin\AdminServiceController::class, 'store']);
    Route::get('/admin/services/{id}/edit', [Admin\AdminServiceController::class, 'edit']);
    Route::post('/admin/services/{id}/update', [Admin\AdminServiceController::class, 'update']);
    Route::post('/admin/services/{id}/delete', [Admin\AdminServiceController::class, 'destroy']);
    Route::post('/admin/services/{id}/assign', [Admin\AdminServiceController::class, 'assignMedecin']);

    // Réservations
    Route::get('/admin/reservations', [Admin\AdminReservationController::class, 'index']);
    Route::post('/admin/reservations/{id}/cancel', [Admin\AdminReservationController::class, 'cancel']);

    // Utilisateurs
    Route::get('/admin/users', [Admin\AdminUserController::class, 'index']);
    Route::post('/admin/users/{id}/set-role', [Admin\AdminUserController::class, 'setRole']);
    Route::post('/admin/users/{id}/toggle', [Admin\AdminUserController::class, 'toggle']);
});
