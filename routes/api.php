<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ContractController; // <--- Ajoute ça en haut !

Route::controller(AuthController::class)->group(function () {
    Route::post('register', 'register');
    Route::post('login', 'login');

    // ZONE SÉCURISÉE (Il faut le Token)
    Route::middleware('auth:api')->group(function () {
        Route::post('logout', 'logout');
        Route::get('user', 'me');
        Route::post('refresh', 'refresh');

        // --- NOUVELLES ROUTES CONTRATS ---
        Route::get('contracts', [ContractController::class, 'index']); // Voir mes contrats
        Route::post('contracts', [ContractController::class, 'store']); // Créer un contrat
    });
});