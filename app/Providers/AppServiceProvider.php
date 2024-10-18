<?php

namespace App\Providers;

use App\Models\Order;
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
        view()->composer('client.layouts.header', function ($view) {
            $view->with(
                'cartTotal',
                auth()->check() ? Order::where('user_id', auth()->user()->id)
                ->where('status', 'cart')
                ->first() : null
            );
        });
    }
}
