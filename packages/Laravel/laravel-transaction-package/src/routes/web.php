<?php

use Illuminate\Support\Facades\Route;
use Laravel\LaravelTransactionPackage\Http\Controllers\web\TransactionController;


Route::get('user/{id}/{lang}', [TransactionController::class,'accountStatement']);
