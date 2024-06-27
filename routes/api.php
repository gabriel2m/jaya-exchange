<?php

use App\Http\Controllers\TransactionController;
use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

Route::name('transactions.')
    ->prefix('transactions')
    ->group(function () {
        Route::post('/', [TransactionController::class, 'store'])->name('store');
        Route::get('{user}', [TransactionController::class, 'index'])->missing(
            fn () => response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND)
        )->name('index');
    });
