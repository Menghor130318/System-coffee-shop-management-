<?php

namespace App\Providers;
use Illuminate\Support\Facades\Schema;
use App\Interfaces\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;
use Illuminate\Support\ServiceProvider;
use App\Interfaces\ProductRepositoryInterface;
use App\Repositories\ProductRepository;
use App\Interfaces\SizeRepositoryInterface;
use App\Repositories\SizeRepository;
use App\Interfaces\SweetnessLevelRepositoryInterface;
use App\Repositories\SweetnessLevelRepository;
use App\Interfaces\IceLevelRepositoryInterface;
use App\Repositories\IceLevelRepository;
use App\Interfaces\ToppingRepositoryInterface;
use App\Repositories\ToppingRepository;
use App\Interfaces\CartRepositoryInterface;
use App\Repositories\CartRepository;
use App\Interfaces\OrderRepositoryInterface;
use App\Repositories\OrderRepository;
use App\Interfaces\ReviewRepositoryInterface;
use App\Repositories\ReviewRepository;
use App\Interfaces\AuthRepositoryInterface;
use App\Repositories\AuthRepository;
use App\Interfaces\ProfileRepositoryInterface;
use App\Repositories\ProfileRepository;
use App\Repositories\DashboardRepository;
use App\Interfaces\DashboardRepositoryInterface;
use App\Repositories\UserRepository;
use App\Interfaces\UserRepositoryInterface;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */


    public function register(): void
    {
        //
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );
        $this->app->bind(
            SizeRepositoryInterface::class,
            SizeRepository::class
        );
        $this->app->bind(
            SweetnessLevelRepositoryInterface::class,
            SweetnessLevelRepository::class
        );
        $this->app->bind(
            IceLevelRepositoryInterface::class,
            IceLevelRepository::class
        );
        $this->app->bind(
            ToppingRepositoryInterface::class,
            ToppingRepository::class
        );
        $this->app->bind(
            CartRepositoryInterface::class,
            CartRepository::class
        );
        $this->app->singleton(
            \App\Services\PriceCalculatorService::class
        );
        $this->app->bind(
            OrderRepositoryInterface::class,
            OrderRepository::class
        );
        $this->app->bind(
            ReviewRepositoryInterface::class,
            ReviewRepository::class
        );
        $this->app->bind(
            AuthRepositoryInterface::class,
            AuthRepository::class
        );
        $this->app->bind(
            ProfileRepositoryInterface::class,
            ProfileRepository::class
        );
        $this->app->bind(
            DashboardRepositoryInterface::class,
            DashboardRepository::class
        );
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     */
public function boot(): void
{
    Schema::defaultStringLength(191);
    \Illuminate\Pagination\Paginator::defaultView('pagination.custom');

    // Share pending order count with admin header for notification badge
    view()->composer(['components.header'], function ($view) {
        $pendingOrdersCount = \App\Models\Order::where('status', 'waiting_payment')->count();
        $view->with('pendingOrdersCount', $pendingOrdersCount);
    });
}
}
