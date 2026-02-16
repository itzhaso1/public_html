<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Erp\ProductController;

Route::prefix('v1')
    ->middleware(['auth:sanctum', 'throttle:erp'])
    ->group(function () {

        Route::prefix('products')->group(function () {

            Route::post('/', [ProductController::class, 'store']);
            Route::post('/store', [ProductController::class, 'storeMultiple']);

            Route::post('/update-price-stock', [ProductController::class, 'updatePriceStock']);
            Route::post('/update-multiple-price-stock', [ProductController::class, 'updateMultiplePriceStock']);

        });

    });
