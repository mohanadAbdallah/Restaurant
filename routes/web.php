<?php

use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::middleware(['guest'])->group(function (){
    Route::get('register', [RegisterController::class, 'create'])->name('auth.register');
    Route::post('register', [RegisterController::class, 'store'])->name('register');

    Route::get('login',[AuthenticateController::class,'showLoginForm'])->name('user.login');
    Route::post('login',[AuthenticateController::class,'login'])->name('user.login.submit');

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post('reset-password',[AuthenticateController::class,'resetPassword'])->name('password.update');

    Route::post('/forgot-password',[AuthenticateController::class,'forgotPassword'])->name('password.email');

    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->middleware('guest')->name('password.reset');

});

Route::middleware(['auth'])->group(function () {

    Route::get('/', function () {
        return view('home');
    })->name('home');


    Route::post('logout',[AuthenticateController::class,'logout'])->name('user.logout');

    Route::get('profile',[AuthenticateController::class,'profile'])->name('user.profile');
    Route::put('profile',[AuthenticateController::class,'update_profile'])->name('profile.update');

    Route::resource('users',UserController::class);

    Route::resource('roles',RoleController::class);

    //Restaurant
    Route::resource('restaurant',RestaurantController::class);

    Route::resource('categories',CategoryController::class);

    Route::resource('items',ItemController::class);

    Route::resource('orders',OrderController::class);

//    Route::resource('sub-categories',SubCategoryController::class);

    Route::post('/categories/{category_id}/subcategories', [CategoryController::class,'store'])->name('subcategories.store');

    Route::resource('sub-categories',SubCategoryController::class);


    Route::get('/dashboard', function () {
        $data = [
            'restaurants' => \App\Models\Restaurant::all()->count(),
            'users' => \App\Models\User::all()->count(),
        ];

        return view('dashboard')->with('data',$data);
    })->name('dashboard');

});



