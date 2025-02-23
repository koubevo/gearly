<?php

use App\Http\Controllers\FilterController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [LandingPageController::class, 'index'])->name('landingPage');

//TODO: add middlewares for other controllers

Route::get('/api/filters/{categoryId}', [FilterController::class, 'getFiltersByCategory']);
Route::get('/api/countries', [LocationController::class, 'getCountries']);
Route::get('/api/cities', [LocationController::class, 'getCities']);

Route::post('/imgs/upload-temp', [OfferController::class, 'uploadTempImages']);

Route::resource('search', SearchController::class)
    ->only(['index']);

Route::resource('offer', OfferController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');

Route::resource('offer', OfferController::class)
    ->only(['index', 'show']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('user', UserController::class)
    ->only(['show']);

require __DIR__ . '/auth.php';