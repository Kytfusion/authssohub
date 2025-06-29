<?php

namespace App\Providers;

use App\Services\BiographyService;
use App\Services\MediaService;
use App\Services\OptionService;
use App\Services\PolicyService;
use App\Services\ProfileService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(BiographyService::class, function ($app) {
            return new BiographyService();
        });

        $this->app->singleton(MediaService::class, function ($app) {
            return new MediaService();
        });

        $this->app->singleton(OptionService::class, function ($app) {
            return new OptionService();
        });

        $this->app->singleton(PolicYService::class, function ($app) {
            return new PolicYService();
        });

        $this->app->singleton(ProfileService::class, function ($app) {
            return new ProfileService();
        });

        $this->app->singleton(UserService::class, function ($app) {
            return new UserService();
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
