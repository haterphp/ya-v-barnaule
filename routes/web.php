<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Web\Auth\AuthController;
use App\Http\Controllers\Web\User\UserController;
use App\Http\Controllers\Web\SiteController as AppController;
use App\Http\Controllers\Dashboard\SiteController as DashboardController;
use \App\Http\Controllers\Dashboard\Location\LocationController;
use \App\Http\Controllers\Dashboard\Category\CategoryController;
use \App\Http\Controllers\Dashboard\User\UserController as DashboardUserController;
use \App\Http\Controllers\Dashboard\Order\OrderController as DashboardOrderController;
use \App\Http\Controllers\Web\Location\LocationController as AppLocationsController;
use App\Http\Controllers\Web\Order\OrderController;
use App\Http\Controllers\Web\User\WishListController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AppController::class, 'index'])->name('home');
Route::get('/catalog', [AppLocationsController::class, 'index'])->name('catalog');
Route::get('/catalog/{location}', [AppLocationsController::class, 'show'])->name('catalog.show');

Route::middleware('guest')->group(function () {
    Route::resource('auth', AuthController::class)->only('create', 'store');
    Route::resource('user', UserController::class)->only('create', 'store');
});

Route::middleware('auth')->group(function () {
    Route::get('auth/destroy', [AuthController::class, 'destroy'])->name('auth.logout');
    Route::post('/user/wish/{location}', [WishListController::class, 'store'])->name('wish.store');
    Route::get('/profile/wish', [WishListController::class, 'index'])->name('profile.wish');
    Route::get('/profile/orders', [OrderController::class, 'index'])->name('profile.orders');
    Route::post('/order/{location}', [OrderController::class, 'store'])->name('order.store');
    
    Route::name('dashboard.')->prefix('dashboard')->middleware('can:admin')->group(function (){
        Route::get('/', [DashboardController::class, 'index'])->name('home');
        Route::resource('locations', LocationController::class);
        Route::resource('categories', CategoryController::class)->except('show');
        Route::resource('users', DashboardUserController::class)->except('show');
        Route::resource('orders', DashboardOrderController::class)->only('index', 'update');
    });
});
