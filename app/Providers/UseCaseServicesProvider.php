<?php

namespace App\Providers;

use App\UseCases\Contracts\User\StoreUserUseCaseInterface;
use App\UseCases\Contracts\User\UpdateUserUseCaseInterface;
use App\UseCases\User\StoreUserUseCase;
use App\UseCases\User\UpdateUserUseCase;
use Illuminate\Support\ServiceProvider;

class UseCaseServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected array $classes = [
        StoreUserUseCaseInterface::class => StoreUserUseCase::class,
        UpdateUserUseCaseInterface::class => UpdateUserUseCase::class
    ];

    public function register(): void
    {
        foreach ($this->classes as $interface => $implementation) {
            $this->app->bind($interface, $implementation);
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
