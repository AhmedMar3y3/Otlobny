<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\FAQController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\HomeController;
use App\Services\PaymentGateway\PaymentService;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DelegateController;
use App\Http\Controllers\Admin\OrderController;

require __DIR__.'/store.php';

//public routes
Route::get('/', [AuthController::class, 'loadLoginPage'])->name('loginPage');
Route::post('/login-admin', [AuthController::class, 'loginUser'])->name('loginUser');
Route::get('payment/success/{transaction_id}/{status}'  ,[PaymentService::class, 'success'])->name('payment.success');
Route::get('payment/failed/{transaction_id}/{status}'   ,[PaymentService::class, 'failed'])->name('payment.failed');


//protected routes
Route::middleware(['auth.admin'])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('admin.logout'); 
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('admin.dashboard');

    // category routes //
    Route::get('/categories', [CategoryController::class, 'index'])->name('admin.categories.index');
    Route::post('/categories', [CategoryController::class, 'store'])->name('admin.categories.store');
    Route::put('/categories/{id}', [CategoryController::class, 'update'])->name('admin.categories.update');
    Route::delete('/categories/{id}', [CategoryController::class, 'destroy'])->name('admin.categories.destroy');

    // order routes //
    Route::get('/orders', [OrderController::class,'index'])->name('admin.orders.index');
    Route::get('/orders/{id}', [OrderController::class,'show'])->name('admin.orders.show');
    Route::put('/assign-delegate/{order}', [OrderController::class,'assignDelegate'])->name('admin.orders.assign');

    // product routes //
    Route::get('/products', [ProductController::class, 'index'])->name('admin.products.index');
    Route::get('/show-product/{id}', [ProductController::class, 'show'])->name('admin.products.show');
    Route::get('/create-product', [ProductController::class, 'create'])->name('admin.products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('admin.products.store');
    Route::get('/edit-product/{id}', [ProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/update-product/{id}', [ProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/delete-product/{id}', [ProductController::class, 'destroy'])->name('admin.products.destroy');

    // delegates routes //
    Route::get('/delegates', [DelegateController::class,'index'])->name('admin.delegates.index');
    Route::get('/delegates/{id}', [DelegateController::class,'show'])->name('admin.delegates.show');
    Route::delete('/delete-delegate/{id}', [DelegateController::class,'destroy'])->name('admin.delegates.destroy');

    // banner routes //
    Route::get('/banners', [BannerController::class, 'index'])->name('admin.banners.index');
    Route::get('/banners/{id}', [BannerController::class, 'show'])->name('admin.banners.show');
    Route::post('/banners', [BannerController::class, 'store'])->name('admin.banners.store');
    Route::put('/banners/{id}', [BannerController::class, 'update'])->name('admin.banners.update');
    Route::delete('/banners/{id}', [BannerController::class, 'destroy'])->name('admin.banners.destroy');

    // setting routes //
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings.index');
    Route::put('/settings', [SettingController::class, 'update'])->name('admin.settings.update');
});
