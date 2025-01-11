<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\SolicitudRepositoryInterface;
use App\Interfaces\SoporteRepositoryInterface;
use App\Interfaces\RequerimientoRepositoryInterface;
use App\Repositories\SolicitudRepository;
use App\Repositories\SoporteRepository;
use App\Repositories\RequerimientoRepository;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(SolicitudRepositoryInterface::class,SolicitudRepository::class);
        $this->app->bind(SoporteRepositoryInterface::class,SoporteRepository::class);
        $this->app->bind(RequerimientoRepositoryInterface::class,RequerimientoRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
