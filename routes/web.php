<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\FilterController;
use App\Http\Controllers\LandingPageController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\RatingController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\WishlistController;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [LandingPageController::class, 'index'])->name('landingPage');

Route::post('/test-auth', function () {
    $user = \Illuminate\Support\Facades\Auth::user();
    return response()->json([
        'auth' => $user ? true : false,
        'user' => $user,
    ]);
});

Route::get('/api/filters/{categoryId}', [FilterController::class, 'getFiltersByCategory']);
Route::get('/api/countries', [LocationController::class, 'getCountries']);
Route::get('/api/cities', [LocationController::class, 'getCities']);

Route::middleware('auth')->group(function () {
    Route::post('/api/wishlist/{offer}', [WishlistController::class, 'toggle']);
});

Route::get('/api/wishlist/{offer}', [WishlistController::class, 'count'])
    ->middleware('auth');

Route::get('/api/chat/{offer}/{buyer}', [ChatController::class, 'loadMessages'])
    ->name('chat.load')
    ->middleware('auth');

Route::post('/api/chat/{offer}/{buyer}', [ChatController::class, 'sendMessage'])
    ->name('chat.send')
    ->middleware('auth');

Route::post('/api/rating', [RatingController::class, 'store'])
    ->middleware('auth')
    ->name('rating.store');

Route::post('/imgs/upload-temp', [OfferController::class, 'uploadTempImages'])
    ->middleware('auth');

Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index')
    ->middleware('auth');

Route::get('/chat/{offer}/{buyer}', [ChatController::class, 'show'])
    ->name('chat.show')
    ->middleware('auth');

Route::get('/chat', [ChatController::class, 'index'])
    ->name('chat.index')
    ->middleware('auth');

Route::resource('search', SearchController::class)
    ->only(['index']);

Route::resource('offer', OfferController::class)
    ->only(['create', 'store', 'edit', 'update', 'destroy'])
    ->middleware('auth');

Route::resource('offer', OfferController::class)
    ->only(['index', 'show']);

Route::post('/offers/{offer}/sell', [OfferController::class, 'sellOffer'])
    ->middleware('auth')
    ->name('offer.sell');

Route::post('/offers/{offer}/receive', [OfferController::class, 'receiveOffer'])
    ->middleware('auth')
    ->name('offer.receive');

Route::post('/offers/{offer}/cancel', [OfferController::class, 'cancelOffer'])
    ->middleware('auth')
    ->name('offer.cancel');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('user', UserController::class)
    ->only(['show']);

require __DIR__ . '/auth.php';