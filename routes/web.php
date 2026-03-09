<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\PaiementController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SeanceController;
use Illuminate\Support\Facades\Route;

// Routes Publiques
Route::get('/', [PublicController::class, 'index'])->name('home');
Route::get('/nos-formations', [PublicController::class, 'formations'])->name('formations.public');

// Routes Authentifiées et Sécurisées par Rôle
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Fallback dashboard (optionnel, pour debug ou base commune)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // GROUPE ADMIN
    Route::middleware(['role:admin'])->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Routes d'export (AVANT les ressources pour éviter les conflits d'URL)
        Route::get('users/export-pdf', [UserController::class, 'exportPdf'])->name('users.exportPdf');
        Route::get('formations/export-pdf', [FormationController::class, 'exportPdf'])->name('formations.exportPdf');
        Route::get('seances/export-pdf', [SeanceController::class, 'exportPdf'])->name('seances.exportPdf');
        Route::get('paiements/export-pdf', [PaiementController::class, 'exportPdf'])->name('paiements.exportPdf');

        Route::resource('formations', FormationController::class)->except(['show']);
        Route::resource('users', UserController::class);
        Route::resource('seances', SeanceController::class);
        Route::resource('paiements', PaiementController::class);
        Route::get('/reservations', [ReservationController::class, 'indexAdmin'])->name('reservations.index');
        Route::patch('/reservations/{reservation}/status', [ReservationController::class, 'updateStatus'])->name('reservations.updateStatus');
    });

    // GROUPE ASSISTANTE
    Route::middleware(['role:assistante'])->prefix('assistante')->name('assistante.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        
        // Routes d'export (AVANT les ressources)
        Route::get('/seances/export-pdf', [SeanceController::class, 'exportPdf'])->name('seances.exportPdf');
        Route::get('/paiements/export-pdf', [PaiementController::class, 'exportPdf'])->name('paiements.exportPdf');

        Route::resource('seances', SeanceController::class); // Planifier séances
        Route::resource('paiements', PaiementController::class); // Enregistrer paiements
        Route::get('/reservations', [ReservationController::class, 'indexAdmin'])->name('reservations.index');
        Route::patch('/reservations/{reservation}/status', [ReservationController::class, 'updateStatus'])->name('reservations.updateStatus');
    });

    // GROUPE MONITEUR
    Route::middleware(['role:moniteur'])->prefix('moniteur')->name('moniteur.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        // Lecture seule : le moniteur consulte les séances, il ne les gère pas
        Route::get('/seances', [SeanceController::class, 'index'])->name('seances.index');
        Route::get('/planning', [SeanceController::class, 'index'])->name('planning'); // alias conservé
    });

    // GROUPE CANDIDAT
    Route::middleware(['role:candidat'])->prefix('candidat')->name('candidat.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/formations', [PublicController::class, 'formations'])->name('formations');
        Route::resource('reservations', ReservationController::class)->only(['index', 'create', 'store', 'destroy']);
        Route::get('/paiements', [PaiementController::class, 'indexCandidat'])->name('paiements.index');
        Route::get('/paiements/{paiement}/pay', [PaiementController::class, 'pay'])->name('paiements.pay');
        Route::post('/paiements/{paiement}/success', [PaiementController::class, 'success'])->name('paiements.success');
        Route::get('/paiements/{paiement}/invoice', [PaiementController::class, 'downloadInvoice'])->name('paiements.invoice');
    });

    // Profile (Commun)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


//contact
use App\Http\Controllers\ContactController;

Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');



//apropos
Route::get('/apropos', function () {
    return view('apropos');
})->name('apropos');
require __DIR__.'/auth.php';
