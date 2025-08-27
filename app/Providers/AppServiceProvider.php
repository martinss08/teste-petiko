<?php

namespace App\Providers;

use App\Repository\Eloquent\TarefaRepository;
use App\Repository\Eloquent\UserRepository;
use App\Repository\Eloquent\StatusRepository;

use App\Repository\Interfaces\StatusRepositoryInterface;
use App\Repository\Interfaces\TarefaRepositoryInterface;
use App\Repository\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );

        $this->app->bind(
            TarefaRepositoryInterface::class,
            TarefaRepository::class
        );

        $this->app->bind(
            StatusRepositoryInterface::class,
            StatusRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Vite::prefetch(concurrency: 3);
    }
}
