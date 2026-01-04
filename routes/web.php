<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers as C;
Route::get('/', function () {
    return view('welcome');
});




// Route::get('/admin-test', function () {
//     return view('layouts.admin');
// }); 

// Route::get('/dashboard/admin', function () {
// return view('dashboard.admin');
// })->middleware('auth');

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', function () {
        return view('dashboard.dashboardAdmin');
    });
    // Route::get('/admin/services', [C\AdminServiceController::class, 'index']);
    // Route::get('/admin/users', [C\AdminUserController::class, 'index']);
});
Route::middleware(['auth', 'role:medecin'])->group(function () {
    Route::get('/dashboard/medecin', function () {
        return view('dashboard.dashboardMedecin');
    });
});

Route::middleware(['auth', 'role:patient'])->group(function () {
    Route::get('/dashboard/dashboardPatient', function () {return view('dashboard.patient');
    });
});


Route::get('/dashboard', [C\DashboardController::class, 'index'])
->middleware('auth')
->name('dashboard');

// Route::get('/admindash', function () {
//     return view('dashboard.dashboardAdmin');
// })->middleware('auth');

// Route::get('/patientdash', function () {
//     return view('dashboard.dashboardPatient');
// });
// Route::get('/medecindash', function () {
//     return view('dashboard.dashboardMedecin');
// });
Route::get('/services/{id}', [C\ServiceController::class, 'show']);
Route::get('/services', [C\ServiceController::class, 'index']);

// Route::get('/login', function () {
//     return view('auth.login');
// })->name('login');

Route::get('/login', [C\AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [C\AuthController::class, 'login']);
Route::post('/logout', [C\AuthController::class, 'logout'])->middleware('auth');

Route::get('/register', [C\AuthController::class, 'showRegister']);
Route::post('/register', [C\AuthController::class, 'register'])->name('register');