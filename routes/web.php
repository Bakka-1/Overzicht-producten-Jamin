<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeverancierController;
use App\Http\Controllers\DeliveryController;

Route::get('/', function () {
    return view('welcome');
});

// Leverancier Routes
Route::get('/leveranciers', [LeverancierController::class, 'index'])->name('leveranciers.index');
Route::get('/leveranciers/{id}/products', [LeverancierController::class, 'showProducts'])->name('leveranciers.products');

// Delivery Routes
Route::get('/deliveries/create/{leverancier_id}/{product_id}', [DeliveryController::class, 'create'])->name('deliveries.create');
Route::post('/deliveries', [DeliveryController::class, 'store'])->name('deliveries.store');
