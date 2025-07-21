<?php

use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DeliveryOptionController;
use App\Http\Controllers\Admin\FilterCategoryController;
use App\Http\Controllers\Admin\FilterController as AdminFilterController;
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
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public Routes
Route::group([], function () {
    Route::get('/', [LandingPageController::class, 'index'])->name('landingPage');

    Route::get('/privacy', function () {
        return Inertia::render('Conditions/Privacy');
    })->name('privacy');

    Route::get('/help', function () {
        return Inertia::render('Help/Index');
    })->name('help');

    Route::resource('offer', OfferController::class)
        ->only(['index', 'show']);

    Route::resource('user', UserController::class)
        ->only(['show']);

    Route::resource('search', SearchController::class)
        ->only(['index']);
});

// Authenticated Routes
Route::group(['middleware' => ['auth']], function () {

    // Offers
    Route::resource('offer', OfferController::class)
        ->only(['create', 'store', 'edit', 'update', 'destroy']);
    Route::post('/offers/{offer}/sell', [OfferController::class, 'sellOffer'])
        ->name('offer.sell');
    Route::post('/offers/{offer}/receive', [OfferController::class, 'receiveOffer'])
        ->name('offer.receive');
    Route::post('/offers/{offer}/cancel', [OfferController::class, 'cancelOffer'])
        ->name('offer.cancel');

    // Profile
    Route::get('/profile', [ProfileController::class, 'show'])
        ->name('profile.show');
    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
    Route::patch('/profile/notifications', [ProfileController::class, 'updateNofitications'])
        ->name('profile.updateNotifications');

    // Chat
    Route::get('/chat/{offer}/{buyer}', [ChatController::class, 'show'])
        ->name('chat.show');
    Route::get('/chat', [ChatController::class, 'index'])
        ->name('chat.index');

    Route::post('/imgs/upload-temp', [OfferController::class, 'uploadTempImages']);

    Route::get('/wishlist', [WishlistController::class, 'index'])
        ->name('wishlist.index');
});


// API Routes
Route::prefix('api')->group(function () {

    // Public API Routes
    Route::get('filters/{filterCategoryId}', [FilterController::class, 'getFiltersByCategory'])
        ->name('api.filters');
    Route::get('countries', [LocationController::class, 'getCountries'])
        ->name('api.countries');
    Route::get('cities', [LocationController::class, 'getCities'])
        ->name('api.cities');

    // Authenticated API Routes    
    Route::middleware('auth')->group(function () {

        // Wishlist
        Route::post('wishlist/{offer}', [WishlistController::class, 'toggle'])
            ->name('wishlist.toggle');
        Route::get('wishlist/{offer}', [WishlistController::class, 'count'])
            ->name('wishlist.count');

        // Chat    
        Route::get('chat/{offer}/{buyer}', [ChatController::class, 'loadMessages'])
            ->name('chat.load');
        Route::post('chat/{offer}/{buyer}', [ChatController::class, 'sendMessage'])
            ->name('chat.send');
        Route::post('chat/{offer}/{buyer}/read', [ChatController::class, 'markAsRead'])
            ->name('chat.read');
        Route::get('chat/unreadChatsCount', [ChatController::class, 'unreadChatsCount'])
            ->name('chat.unreadChatsCount');

        // Rating    
        Route::post('rating', [RatingController::class, 'store'])
            ->name('rating.store');
    });
});

// Admin Routes
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->as('admin.')
    ->group(
        function () {
            Route::get('/', function () {
                return Inertia::render('Admin/Index');
            })->name('index');

            Route::resource('brands', BrandController::class);
            Route::resource('categories', CategoryController::class);
            Route::resource('filter-categories', FilterCategoryController::class);
            Route::resource('filters', AdminFilterController::class);
            Route::resource('delivery-options', DeliveryOptionController::class);
        }
    );

require __DIR__ . '/auth.php';