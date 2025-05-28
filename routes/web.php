<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DeliveryOptionController;
use App\Http\Controllers\Admin\FilterCategoryController;
use App\Http\Controllers\Admin\FilterFcMappingController;
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
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [LandingPageController::class, 'index'])->name('landingPage');

Route::get('/privacy', function () {
    return Inertia::render('Conditions/Privacy');
})->name('privacy');

Route::get('/help', function () {
    return Inertia::render('Help/Index');
})->name('help');

Route::get('/api/filters/{filterCategoryId}', [FilterController::class, 'getFiltersByCategory'])
    ->name('api.filters');
Route::get('/api/countries', [LocationController::class, 'getCountries'])
    ->name('api.countries');
Route::get('/api/cities', [LocationController::class, 'getCities'])
    ->name('api.cities');

Route::post('/api/wishlist/{offer}', [WishlistController::class, 'toggle'])
    ->name('wishlist.toggle')
    ->middleware('auth');

Route::get('/api/wishlist/{offer}', [WishlistController::class, 'count'])
    ->name('wishlist.count')
    ->middleware('auth');

Route::get('/api/chat/{offer}/{buyer}', [ChatController::class, 'loadMessages'])
    ->name('chat.load')
    ->middleware('auth');

Route::post('chat/{offer}/{buyer}', function () {
    Log::info('📥 Route hit - testing only.');
    return response()->json(['ok' => true]);
})->middleware('auth:sanctum')
    ->name('chat.send');

Route::post('/api/chat/{offer}/{buyer}/read', [ChatController::class, 'markAsRead'])
    ->name('chat.read')
    ->middleware('auth');

Route::get('/api/chat/unreadChatsCount', [ChatController::class, 'unreadChatsCount'])
    ->name('chat.unreadChatsCount')
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

Route::get('/admin', function () {
    return Inertia::render('Admin/Index');
})
    ->middleware(['auth', 'admin'])
    ->name('admin.index');

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('brands', BrandController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('filter-categories', FilterCategoryController::class);
    Route::resource('filters', AdminFilterController::class);
    Route::resource('delivery-options', DeliveryOptionController::class);
});

Route::resource('user', UserController::class)
    ->only(['show']);

require __DIR__ . '/auth.php';