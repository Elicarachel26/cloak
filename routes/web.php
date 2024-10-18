<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Client\AccountController as ClientAccountController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\Client\ReedemPointController;
use App\Http\Controllers\Client\UserOrderController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PickupController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RewardController;
use App\Http\Controllers\UserRewardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LocationController;
use App\Mail\MyEmail;
use Illuminate\Support\Facades\Mail;

//LOCATION ROUTE
Route::get('/provinces', [LocationController::class, 'getProvinces']);
Route::get('/regencies/{provinceId}', [LocationController::class, 'getRegencies']);
Route::get('/districts/{regencyId}', [LocationController::class, 'getDistricts']);
Route::get('/villages/{districtId}', [LocationController::class, 'getVillages']);

Route::get('login', [AuthController::class, 'login'])->name('login.index')->middleware('guest');
Route::post('login', [AuthController::class, 'doLogin'])->name('login.auth')->middleware('guest');

Route::get('register', [AuthController::class, 'register'])->name('register.index')->middleware('guest');
Route::post('register', [AuthController::class, 'doRegister'])->name('register.auth')->middleware('guest');

Route::get('/google/redirect', [AuthController::class, 'redirectToGoogle'])->name('google.redirect')->middleware('guest');
Route::get('/google/callback', [AuthController::class, 'handleGoogleCallback'])->name('google.callback')->middleware('guest');

Route::get('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot-password.index')->middleware('guest');
Route::post('forgot-password', [AuthController::class, 'doForgotPassword'])->name('forgot-password.auth')->middleware('guest');

Route::get('reset-password/{token}', [AuthController::class, 'resetPassword'])->name('reset-password.index')->middleware('guest');
Route::post('reset-password/{token}', [AuthController::class, 'doResetPassword'])->name('reset-password.auth')->middleware('guest');

Route::post('logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');


Route::middleware('auth')->prefix('admin')->group(function () {
    Route::middleware('role:admin,driver')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('account', [AccountController::class, 'account'])->name('account.index');
        Route::post('account', [AccountController::class, 'accountUpdate'])->name('account.update');
        Route::post('account/change-photo', [AccountController::class, 'changePhoto'])->name('account.change-photo');
        Route::post('account/change-password', [AccountController::class, 'changePassword'])->name('account.change-password');

        Route::resource('admin', AdminController::class);

        Route::resource('product', ProductController::class)->except('show');

        Route::resource('reward', RewardController::class)->except('show');

        Route::resource('customer', CustomerController::class)->except(['create', 'store', 'show']);

        Route::get('order', [OrderController::class, 'index'])->name('order.index');
        Route::put('order/{order}/driver', [OrderController::class, 'setDriver'])->name('order.driver');
        Route::post('order/{order}/cancel', [OrderController::class, 'cancel'])->name('order.cancel');
        Route::post('order/{order}/complete', [OrderController::class, 'complete'])->name('order.complete');

        Route::get('user-reward', [UserRewardController::class, 'index'])->name('user-reward.index');
        Route::post('user-reward/{userReward}/delivered', [UserRewardController::class, 'delivered'])->name('user-reward.delivered');
    });

    Route::middleware('role:driver')->group(function () {
        Route::get('pickup', [PickupController::class, 'index'])->name('pickup.index');
        Route::post('pickup/{pickup}/pickedup', [PickupController::class, 'pickedup'])->name('pickup.pickedup');
        Route::post('pickup/{pickup}/delivered', [PickupController::class, 'delivered'])->name('pickup.delivered');
    });
});


// CLIENT ROUTE
Route::get('/', [HomeController::class, 'index'])->name('client.home.index');
Route::get('products', [ClientProductController::class, 'index'])->name('client.product.index');

Route::middleware('auth')->group(function () {
    Route::get('cart', [CartController::class, 'index'])->name('client.cart.index');
    Route::post('cart/add', [CartController::class, 'addToCart'])->name('client.cart.add');
    Route::delete('cart/remove', [CartController::class, 'removeFromCart'])->name('client.cart.remove');
    Route::put('cart/checkout/{order}', [CartController::class, 'checkout'])->name('client.checkout.store');

    Route::get('history-order', [UserOrderController::class, 'index'])->name('client.order.index');
    Route::put('history-order/{order}/proof-payment', [UserOrderController::class, 'proofPayment'])->name('client.order.proof-payment');

    Route::get('reedem-point', [ReedemPointController::class, 'index'])->name('client.reedem-point.index');
    Route::post('reedem-point', [ReedemPointController::class, 'store'])->name('client.reedem-point.store');
    Route::post('reedem-point/complete', [ReedemPointController::class, 'complete'])->name('client.reedem-point.complete');

    Route::match(['get', 'put'], 'account', [ClientAccountController::class, 'index'])->name('client.account.index');
    Route::match(['get', 'put'], 'account/change-password', [ClientAccountController::class, 'changePassword'])->name('client.account.change-password');
});

Route::get('/send-email', function () {
    Mail::to('2182018@unai.edu')->send(new MyEmail());
    return 'Email sent successfully!';
});

