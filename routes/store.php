<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Store\AuthController;
use App\Http\Controllers\Store\HomeController;
use App\Http\Controllers\Store\OrderController;
use App\Http\Controllers\Store\ProductController;
use App\Http\Controllers\Store\ProfileController;
use App\Http\Controllers\Store\CategoryController;

Route::prefix('store')->group(function () {

    Route::get('/', [AuthController::class, 'loadLoginPage'])->name('storeloginPage');
    Route::post('/login', [AuthController::class, 'loginUser'])->name('loginStore');
    Route::get('/register', [AuthController::class, 'loadRegisterPage'])->name('register');
    Route::post('/register-user', [AuthController::class, 'registerUser'])->name('registerUser');

    //protected routes
    Route::get('/dashboard', [HomeController::class, 'stats'])->name('store.dashboard');
    Route::middleware(['auth.store'])->group(function () {
        Route::post('/logout',  [AuthController::class, 'logout'])->name('store.logout');

        // profile routes //
        Route::get('/profile', [ProfileController::class, 'getProfile'])->name('store.profile.index');
        Route::put('/profile', [ProfileController::class, 'updateProfile'])->name('store.profile.update');
        Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('store.profile.password');

        // order routes //
        Route::get('/orders',                  [OrderController::class, 'index'])->name('store.orders.index');
        Route::get('/orders/{id}',             [OrderController::class, 'show'])->name('store.orders.show');
        Route::post('/mark-waiting/{id}',      [OrderController::class, 'markAsWaiting'])->name('store.orders.markAsWaiting');

        // category routes //
        Route::get('/category',         [CategoryController::class, 'index'])->name('store.categories.index');
        Route::post('/category',        [CategoryController::class, 'store'])->name('store.categories.store');
        Route::put('/category/{id}',    [CategoryController::class, 'update'])->name('store.categories.update');
        Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('store.categories.destroy');

        // product routes //
        Route::get('/products',              [ProductController::class, 'index'])->name('store.products.index');
        Route::get('/show-product/{id}',     [ProductController::class, 'show'])->name('store.products.show');
        Route::get('/create-product',        [ProductController::class, 'create'])->name('store.products.create');
        Route::post('/products',             [ProductController::class, 'store'])->name('store.products.store');
        Route::get('/edit-product/{id}',     [ProductController::class, 'edit'])->name('store.products.edit');
        Route::put('/update-product/{id}',   [ProductController::class, 'update'])->name('store.products.update');
        Route::delete('/delete-product/{id}',[ProductController::class, 'destroy'])->name('store.products.destroy');
        Route::post('/toggle-product/{id}',  [ProductController::class, 'toggleActive'])->name('store.products.toggleActive');
    });
});
