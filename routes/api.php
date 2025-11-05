<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\ContactController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Ici vous pouvez enregistrer les routes API pour votre application. 
| Ces routes sont chargées par le RouteServiceProvider dans le groupe 
| "api" middleware.
|
*/

/*
|--------------------------------------------------------------------------
| Route Authentification (Sanctum)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/*
|--------------------------------------------------------------------------
| Routes Properties
|--------------------------------------------------------------------------
*/
Route::prefix('properties')->group(function () {
    Route::get('/', [PropertyController::class, 'index']);           // Liste toutes les propriétés
    Route::get('/{id}', [PropertyController::class, 'show']);        // Affiche une propriété spécifique
    Route::post('/', [PropertyController::class, 'store']);          // Crée une nouvelle propriété
    Route::put('/{id}', [PropertyController::class, 'update']);      // Met à jour une propriété existante
    Route::delete('/{id}', [PropertyController::class, 'destroy']);  // Supprime une propriété
});
// Route pour récupérer les catégories uniques
Route::get('/categories', [PropertyController::class, 'getCategories']);
/*
|--------------------------------------------------------------------------
| Routes Reservations
|--------------------------------------------------------------------------
|
| Utilisation de apiResource pour toutes les actions CRUD
*/
Route::apiResource('reservations', ReservationController::class);

/*
|--------------------------------------------------------------------------
| Routes Contact
|--------------------------------------------------------------------------
|
| Limite les requêtes à 10 par minute pour éviter les abus
*/
Route::middleware('throttle:10,1')->post('/contacts', [ContactController::class, 'store']);
