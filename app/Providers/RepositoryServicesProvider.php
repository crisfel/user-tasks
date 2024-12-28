<?php

namespace App\Providers;

use App\Repositories\Contracts\Task\TaskRepositoryInterface;
use App\Repositories\Contracts\User\UserRepositoryInterface;
use App\Repositories\Contracts\UserTask\UserTaskRepositoryInterface;
use App\Repositories\Task\TaskRepository;
use App\Repositories\User\UserRepository;
use App\Repositories\UserTask\UserTaskRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServicesProvider extends ServiceProvider
{
    /**
     * Register services.
     */

    protected array $classes = [
        UserRepositoryInterface::class => UserRepository::class,
        TaskRepositoryInterface::class => TaskRepository::class,
        UserTaskRepositoryInterface::class => UserTaskRepository::class,
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
