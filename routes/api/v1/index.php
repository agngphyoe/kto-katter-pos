<?php

use App\Http\Controllers\API\ActivityLogAPIController;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductsAPIController;
use App\Http\Controllers\API\SalesAPIController;
use App\Http\Controllers\API\CategoryAPIController;
use App\Http\Controllers\API\POSAPIController;
use App\Http\Controllers\API\ShopperAPIController;
use App\Http\Controllers\API\SaleConsultantAPIController;
use App\Http\Controllers\API\DashboardAPIController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// User login
Route::post('/login', [AuthController::class, 'login']);

// Route::get('/company-settings', [CompanySettingsAPIController::class, 'index'])->name('company-settings');

Route::middleware('auth:api')->group(function () {

    Route::get('/me', [AuthController::class, 'profile']);

    Route::post('/change-info', [AuthController::class, 'changeInfo']);

    Route::post('/change-password', [AuthController::class, 'changePassword']);

    Route::get('/dashboard-sale-data', [DashboardAPIController::class, 'index']);

    Route::prefix('categories')->group(function () {
        Route::controller(CategoryAPIController::class)->group(function () {
            Route::get('/', 'index');
        });
    });

    Route::prefix('products')->group(function () {
        Route::controller(ProductsAPIController::class)->group(function () {
            Route::get('/get-products-by-category', 'GetProductsByCategory');
        });
    });

    Route::prefix('sales')->group(function () {
        Route::controller(POSAPIController::class)->group(function () {
            Route::get('/', 'index');
            Route::get('/details', 'details');
            Route::post('/checkout', 'checkout');
        });
    });

    Route::prefix('shoppers')->group(function () {
        Route::controller(ShopperAPIController::class)->group(function () {
            Route::get('/', 'index');
            Route::post('/store', 'store');
        });
    });

    Route::prefix('sale-staffs')->group(function () {
        Route::controller(SaleConsultantAPIController::class)->group(function () {
            Route::get('/', 'index');
        });
    });

    Route::post('/logout', [AuthController::class, 'logout']);
});
