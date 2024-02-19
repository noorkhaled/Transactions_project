<?php

namespace Laravel\LaravelTransactionPackage;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Laravel\LaravelTransactionPackage\Http\Controllers\api\TransactionController;
use Laravel\LaravelTransactionPackage\Models\Transactions;
use Laravel\LaravelTransactionPackage\View\Components\accountStatement;

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
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/../src/resources/lang', 'LaravelTransactionPackage');
        $this->publishes([__DIR__ . '/../resources/lang' =>$this->app->langPath('')]);
        $this->loadViewsFrom(__DIR__ . '/../resources/views/components', 'LaravelTransactionPackage');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'LaravelTransactionPackage');
        $this->publishes([__DIR__.'/../resources/views'=>resource_path('resources/views')]);
        $this->publishes([__DIR__ . '/../src/View/Components' =>resource_path('app/View/Components')]);
        $this->publishes([__DIR__ . '/../config/transactions.php' =>'config/transactions.php']);
        $this->loadRoutesFrom(__DIR__.'/../src/routes/api.php');
        $this->loadRoutesFrom(__DIR__.'/../src/routes/web.php');
        Blade::component('account-statement',AccountStatement::class);
    }
}
