<?php

namespace App\Providers;

use App\Events\CreateTaskEvent;
use App\Listeners\UpdateCacheListener;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\TaskRepository;
use App\Repositories\UserRepository;
use App\Services\AuthService;
use App\Services\Interfaces\AuthServiceInterface;
use App\Services\Interfaces\TaskServiceInterface;
use App\Services\Interfaces\UserServiceInterface;
use App\Services\TaskService;
use App\Services\UserService;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;
use Laravel\Sanctum\PersonalAccessToken;
use Laravel\Sanctum\Sanctum;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthServiceInterface::class, AuthService::class);
        $this->app->bind(UserServiceInterface::class, UserService::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(TaskServiceInterface::class, TaskService::class);
        $this->app->bind(TaskRepositoryInterface::class, TaskRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Event::listen(
            CreateTaskEvent::class,
            UpdateCacheListener::class
        );
    }
}
