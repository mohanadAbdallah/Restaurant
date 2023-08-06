<?php

use App\Http\Controllers\Api\V1\Auth\AuthenticateController;
use App\Http\Controllers\Api\V1\Auth\RegisterController;
use App\Http\Controllers\Api\V1\Home\CartController;
use App\Http\Controllers\Api\V1\Home\PaymentController;
use App\Http\Controllers\Api\V1\Home\RestaurantController;
use App\Http\Controllers\Api\v1\Home\OrdersController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->group(function () {
    Route::post('/register', [RegisterController::class, 'store'])->name('register');
    Route::post('/login', [AuthenticateController::class, 'login'])->name('login');
});

Route::middleware('auth:sanctum')->group(function () {

    Route::post('logout', [AuthenticateController::class, 'logout']);
    Route::get('profile', [AuthenticateController::class, 'profile']);
    Route::post('update-profile', [AuthenticateController::class, 'update_profile']);

    Route::post('/forgot-password', [AuthenticateController::class, 'forgotPassword'])->name('password.email');
    Route::post('reset-password', [AuthenticateController::class, 'resetPassword'])->name('password.update');


    Route::apiResource('restaurants', RestaurantController::class);
    Route::apiResource('orders', OrdersController::class);

    Route::apiResource('cart', CartController::class)->only(['index', 'store']);

    Route::delete('delete-from-cart', [CartController::class, 'deleteFromCart'])->name('delete_from_cart');

    Route::post('orders/{order}/stripe/payment-intent', [PaymentController::class, 'createStripePaymentIntent']);
});
