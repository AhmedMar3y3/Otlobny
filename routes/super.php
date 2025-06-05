<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Super\HomeController;
use App\Http\Controllers\Super\AuthController;
use App\Http\Controllers\Super\AdminController;
use App\Http\Controllers\Super\StoreController;
use App\Http\Controllers\Super\BannerController;
use App\Http\Controllers\Super\SettingController;
use App\Http\Controllers\Super\CategoryController;
use App\Http\Controllers\Super\DelegateController;


Route::prefix('super')->group(function () {

    //public routes
    Route::get('/',            [AuthController::class, 'loadLoginPage'])->name('superLoginPage');
    Route::post('/login-super', [AuthController::class, 'loginUser'])->name('loginSuper');


    //protected routes
    Route::middleware(['auth.super'])->group(function () {
        Route::post('/logout',  [AuthController::class, 'logout'])->name('super.logout');
        Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('super.dashboard');

        // admin routes //
        Route::get('/admins',        [AdminController::class, 'index'])->name('super.admins.index');
        Route::post('/admins',       [AdminController::class, 'store'])->name('super.admins.store');
        Route::delete('/admins/{id}', [AdminController::class, 'destroy'])->name('super.admins.destroy');

        // category routes //
        Route::get('/categories',        [CategoryController::class, 'index'])->name('super.categories.index');
        Route::post('/categories',       [CategoryController::class, 'store'])->name('super.categories.store');
        Route::put('/categories/{id}',   [CategoryController::class, 'update'])->name('super.categories.update');
        Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('super.categories.destroy');

        // store routes //
        Route::get('/stores',               [StoreController::class, 'index'])->name('super.stores.index');
        Route::get('/stores/{id}',          [StoreController::class, 'show'])->name('super.stores.show');
        Route::delete('/stores/{id}',       [StoreController::class, 'destroy'])->name('super.stores.destroy');
        Route::post('/stores/{id}/change-admin',[StoreController::class, 'changeAdmin'])->name('super.stores.changeAdmin');

        // Category Store Products Routes
        Route::get('categories/{category}/stores', [CategoryController::class, 'getStoresByCategory'])->name('super.categories.stores');
        Route::get('categories/{category}/stores/{store}/products', [CategoryController::class, 'getStoreProducts'])->name('super.categories.store-products');
        Route::put('categories/{category}/stores/{store}/products/{product}', [CategoryController::class, 'updateStoreProduct'])->name('super.categories.update-store-product');
        Route::delete('categories/{category}/stores/{store}/products/{product}', [CategoryController::class, 'deleteStoreProduct'])->name('super.categories.delete-store-product');
        Route::get('categories/{category}/stores/{store}/products/{product}', [CategoryController::class, 'showStoreProduct'])->name('super.categories.show-store-product');

        // // delegates routes //
        // Route::get('/delegates',              [DelegateController::class,'index'])->name('super.delegates.index');
        // Route::get('/delegates/{id}',         [DelegateController::class,'show'])->name('super.delegates.show');
        // Route::delete('/delete-delegate/{id}',[DelegateController::class,'destroy'])->name('super.delegates.destroy');

        // banner routes //
        Route::get('/banners',        [BannerController::class, 'index'])->name('super.banners.index');
        Route::get('/banners/{id}',   [BannerController::class, 'show'])->name('super.banners.show');
        Route::post('/banners',       [BannerController::class, 'store'])->name('super.banners.store');
        Route::put('/banners/{id}',   [BannerController::class, 'update'])->name('super.banners.update');
        Route::delete('/banners/{id}', [BannerController::class, 'destroy'])->name('super.banners.destroy');

        // setting routes //
        Route::get('/settings', [SettingController::class, 'index'])->name('super.settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('super.settings.update');
    });
});
