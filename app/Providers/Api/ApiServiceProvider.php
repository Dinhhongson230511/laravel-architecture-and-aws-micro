<?php

namespace App\Providers\Api;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Repositories\Eloquents\UserRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Eloquents\RoleRepository;
use App\Repositories\Interfaces\RoleRepositoryInterface;
use App\Repositories\Eloquents\ProductRepository;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use App\Repositories\Eloquents\OrderRepository;
use App\Repositories\Interfaces\OrderRepositoryInterface;
use App\Repositories\Eloquents\PermissionRepository;
use App\Repositories\Interfaces\PermissionRepositoryInterface;
use Illuminate\Support\Facades\Gate;
use App\Models\User;

class ApiServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(RoleRepositoryInterface::class, RoleRepository::class);
        $this->app->bind(ProductRepositoryInterface::class, ProductRepository::class);
        $this->app->bind(OrderRepositoryInterface::class, OrderRepository::class);
        $this->app->bind(PermissionRepositoryInterface::class, PermissionRepository::class);
    }

    public function boot(): void
    {
        Gate::define('view', function(User $user, $model) {
            return $user->hasAccess("view_{$model}") || $user->hasAccess("edit_{$model}");
        });

        Gate::define('edit', function(User $user, $model) {
            return $user->hasAccess("edit_{$model}");
        });
    }
}
