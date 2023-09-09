<?php

namespace App\Providers;

use App\Services\AbuseDetection\AbuseDetector;
use App\Services\AbuseDetection\Komprehend;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AbuseDetector::class, function () {
            return new Komprehend(
                config('services.komprehend.token')
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
