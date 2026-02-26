<?php

namespace App\Providers;

use App\Http\View\Composers\SidebarComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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
    // Force HTTPS in production
    if (config('app.env') === 'production') {
        \URL::forceScheme('https');
    }

    // Register View Composer for seller sidebar
    View::composer('layouts.sellersidebar', SidebarComposer::class);

    // Register View Composer for buyer sidebar
    View::composer('layouts.buyersidebar', SidebarComposer::class);
}
}
