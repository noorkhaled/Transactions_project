<?php
use Illuminate\Support\Facades\Route;
use Laravel\LaravelTransactionPackage\Http\Controllers\api\TransactionController;


Route::apiResource('transactions', TransactionController::class);
