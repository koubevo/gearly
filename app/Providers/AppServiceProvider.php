<?php

namespace App\Providers;

use App;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;
use App\Models\Offer;
use App\Policies\OfferPolicy;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;
use \Illuminate\Support\Facades\Auth;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
        Gate::policy(Offer::class, OfferPolicy::class);

        Inertia::share('locale', fn() => app()->getLocale());
    }
}
