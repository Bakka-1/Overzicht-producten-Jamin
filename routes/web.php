<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeverancierController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\ApiController;

Route::get('/', function () {
    return view('welcome');
});

// Leverancier Routes
Route::get('/leveranciers', [LeverancierController::class, 'index'])->name('leveranciers.index');
Route::get('/leveranciers/{id}/products', [LeverancierController::class, 'showProducts'])->name('leveranciers.products');

// Delivery Routes
Route::get('/deliveries/create/{leverancier_id}/{product_id}', [DeliveryController::class, 'create'])->name('deliveries.create');
Route::post('/deliveries', [DeliveryController::class, 'store'])->name('deliveries.store');

// API Routes for AJAX/JSON responses
Route::prefix('api')->group(function () {
    Route::get('/leveranciers', [ApiController::class, 'getLeveranciers']);
    Route::get('/leveranciers/{id}/products', [ApiController::class, 'getProductsByLeverancier']);
    Route::get('/products/{id}/stock', [ApiController::class, 'getProductStock']);
});
