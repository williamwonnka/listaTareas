<?php

namespace App\Providers;

use App\Repository\AuthenticationRepository;
use App\Service\AuthenticationService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AuthenticationRepository::class, function () {
            return new AuthenticationRepository();
        });

        $this->app->singleton(AuthenticationService::class, function () {
            return new AuthenticationService(
                app()->make(AuthenticationRepository::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
