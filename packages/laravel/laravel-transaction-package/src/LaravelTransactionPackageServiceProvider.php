<?php

namespace laravel\LaravelTransactionPackage;
use laravel\LaravelTransactionPackage\Http\Controllers\TransactionController;
use laravel\LaravelTransactionPackage\Models\Transactions;
use Illuminate\Support\ServiceProvider;

class LaravelTransactionPackageServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Register controllers if needed
        $this->app->bind(TransactionController::class, function () {
            return new TransactionController();
        });

        // Register models if needed
        $this->app->singleton(Transactions::class, function () {
            return new Transactions();
        });

    }

    public function boot(): void
    {
        $this->loadMigrationsFrom(__DIR__.'/Database/Migrations');
    }
}
