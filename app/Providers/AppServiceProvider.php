<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Http\GuzzleClientService;
use App\Services\Http\HttpClientInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(HttpClientInterface::class, GuzzleClientService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
