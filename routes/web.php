<?php

use App\Http\Controllers\Auth\AuthenticateController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\RoleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ChatsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PaymentsController;
use App\Http\Controllers\PlanController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
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

Route::middleware(['guest'])->group(function () {

    Route::get('register', [RegisterController::class, 'create'])->name('auth.register');
    Route::post('register', [RegisterController::class, 'store'])->name('register');

    Route::get('login', [AuthenticateController::class, 'showLoginForm'])->name('user.login');
    Route::post('login', [AuthenticateController::class, 'login'])->name('user.login.submit');

    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post('reset-password', [AuthenticateController::class, 'resetPassword'])->name('password.update');

    Route::post('/forgot-password', [AuthenticateController::class, 'forgotPassword'])->name('password.email');
    Route::get('/wait-for-reset', [AuthenticateController::class, 'wait'])->name('reset.wait');

    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->middleware('guest')->name('password.reset');

});

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::group(['prefix' => 'home', 'as' => 'home'], function () {
    Route::get('/restaurants/{restaurant}', [HomeController::class, 'showRestaurant'])->name('.restaurant.show');
    Route::get('/categories/{category}', [HomeController::class, 'showCategory'])->name('.category.show');
});


Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::middleware(['auth'])->group(function () {

    Route::post('logout', [AuthenticateController::class, 'logout'])->name('user.logout');
    Route::get('profile', [AuthenticateController::class, 'profile'])->name('user.profile');

    Route::prefix('dashboard')->group(function () {

        Route::get('/', function () {
            $data = [
                'restaurants' => \App\Models\Restaurant::all()->count(),
                'users' => \App\Models\User::all()->count(),
                'orders' => \App\Models\Order::whereHas('items', function ($q){
                    $q->where('restaurant_id', auth()->user()->restaurant?->id);
                })->count()
            ];
            return view('dashboard')->with('data', $data);

        })->middleware('role:Admin|Super Admin|Data Entry|Financial')
            ->name('dashboard');

        Route::put('profile', [AuthenticateController::class, 'update_profile'])->name('profile.update');

        Route::resource('users', UserController::class);

        Route::get('customers', [UserController::class, 'customers'])->name('auth.customers');

        Route::resource('roles', RoleController::class);

        //Restaurant
        Route::resource('restaurant', RestaurantController::class);

        //categories
        Route::resource('categories', CategoryController::class);


        Route::post('/categories/{category_id}/subcategories', [CategoryController::class, 'store'])->name('subcategories.store');

        //items
        Route::resource('items', ItemController::class);

        //orders
        Route::resource('orders', OrderController::class);

    });

    Route::get('/{id}/chat', [ChatsController::class, 'index'])->name('chat.index');

    Route::get('/chat/respondToUser', [ChatsController::class, 'respondToUserChat'])->name('chat.respondToUserChat');


    Route::get('/messages', [ChatsController::class, 'fetchMessages'])->name('fetchMessages');
    Route::get('/getMessages', [ChatsController::class, 'getMessages'])->name('getMessages');

    Route::get('/old-messages', [ChatsController::class, 'fetchOldMessages'])->name('fetchOldMessages');

    Route::post('/messages/send/{id}', [ChatsController::class, 'sendMessage'])->name('chat.message.send');

    Route::post('/messages/respondToUser/{id}', [ChatsController::class, 'respondToUser'])->name('chat.respondToUser');

// Route::resource('/plans',PlanController::class);
    // Route::post('/subscriptions',[PlanController::class,'subscriptions'])->name('subscriptions.create');

    Route::post('/cart/add', [\App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');

    Route::get('/cart/view', [CartController::class, 'viewCart'])->name('cart.view');
    Route::patch('update-cart', [CartController::class, 'update'])->name('update.cart');
    Route::delete('delete-from-cart', [CartController::class, 'delete'])->name('delete.from.cart');

    Route::get('payments/{order}/pay', [PaymentsController::class, 'create'])
        ->name('orders.payment.create');

    Route::post('orders/{order}/stripe/payment-intent', [PaymentsController::class, 'createStripePaymentIntent'])
        ->name('stripe.paymentIntent.create');

    Route::get('orders/{order}/pay/stripe/callback', [PaymentsController::class, 'confirm'])
        ->name('stripe.return');

});


