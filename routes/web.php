<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\StoreController;
use App\Services\PaymentGateway\PaymentService;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DelegateController;

require __DIR__.'/store.php';

//public routes
Route::get('/',            [AuthController::class, 'loadLoginPage'])->name('loginPage');
Route::post('/login-admin',[AuthController::class, 'loginUser'])->name('loginUser');
Route::get('payment/success/{transaction_id}/{status}'  ,[PaymentService::class, 'success'])->name('payment.success');
Route::get('payment/failed/{transaction_id}/{status}'   ,[PaymentService::class, 'failed'])->name('payment.failed');


//protected routes
Route::middleware(['auth.admin'])->group(function () {
    Route::post('/logout',  [AuthController::class, 'logout'])->name('admin.logout'); 
    Route::get('/dashboard',[HomeController::class, 'dashboard'])->name('admin.dashboard');

    // category routes //
    Route::get('/categories',        [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/categories',       [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/categories/{id}',   [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{id}',[CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // store routes //
    Route::get('/stores',               [StoreController::class, 'index'])->name('admin.stores.index');
    Route::get('/stores/{id}',          [StoreController::class, 'show'])->name('admin.stores.show');
    Route::delete('/stores/{id}',       [StoreController::class, 'destroy'])->name('admin.stores.destroy');
    Route::post('/stores/{id}/activate',[StoreController::class, 'activate'])->name('admin.stores.activate');

    // order routes //
    Route::get('/orders',                 [OrderController::class,'index'])->name('admin.orders.index');
    Route::get('/orders/{id}',            [OrderController::class,'show'])->name('admin.orders.show');
    Route::put('/assign-delegate/{order}',[OrderController::class,'assignDelegate'])->name('admin.orders.assign');

    // delegates routes //
    Route::get('/delegates',              [DelegateController::class,'index'])->name('admin.delegates.index');
    Route::get('/delegates/{id}',         [DelegateController::class,'show'])->name('admin.delegates.show');
    Route::delete('/delete-delegate/{id}',[DelegateController::class,'destroy'])->name('admin.delegates.destroy');

    // banner routes //
    Route::get('/banners',        [BannerController::class, 'index'])->name('admin.banners.index');
    Route::get('/banners/{id}',   [BannerController::class, 'show'])->name('admin.banners.show');
    Route::post('/banners',       [BannerController::class, 'store'])->name('admin.banners.store');
    Route::put('/banners/{id}',   [BannerController::class, 'update'])->name('admin.banners.update');
    Route::delete('/banners/{id}',[BannerController::class, 'destroy'])->name('admin.banners.destroy');

    // setting routes //
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('admin.settings.update');
});
