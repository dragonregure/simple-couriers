<?php

namespace App\Providers;

use App\Modules\Couriers\Contracts\CourierRepositoryInterface;
use App\Modules\Couriers\Repositories\EloquentCourierRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CourierRepositoryInterface::class, EloquentCourierRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
