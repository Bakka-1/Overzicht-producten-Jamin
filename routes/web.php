<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LeverancierController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/leveranciers', [LeverancierController::class, 'index'])->name('leveranciers.index');
    Route::get('/leveranciers/{id}/products', [LeverancierController::class, 'showProducts'])->name('leveranciers.products');
    
    Route::get('/deliveries/create/{leverancier_id}/{product_id}', [DeliveryController::class, 'create'])->name('deliveries.create');
    Route::post('/deliveries', [DeliveryController::class, 'store'])->name('deliveries.store');
});

// API Routes for AJAX/JSON responses
Route::prefix('api')->group(function () {
    Route::get('/leveranciers', [ApiController::class, 'getLeveranciers']);
    Route::get('/leveranciers/{id}/products', [ApiController::class, 'getProductsByLeverancier']);
    Route::get('/products/{id}/stock', [ApiController::class, 'getProductStock']);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
