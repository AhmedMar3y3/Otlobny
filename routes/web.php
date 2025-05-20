<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\StoreController;
use App\Services\PaymentGateway\PaymentService;
use App\Http\Controllers\Admin\DelegateController;

require __DIR__.'/store.php';
require __DIR__.'/super.php';

//public routes
Route::get('/',            [AuthController::class, 'loadLoginPage'])->name('loginPage');
Route::post('/login-admin',[AuthController::class, 'loginUser'])->name('loginUser');
Route::get('payment/success/{transaction_id}/{status}'  ,[PaymentService::class, 'success'])->name('payment.success');
Route::get('payment/failed/{transaction_id}/{status}'   ,[PaymentService::class, 'failed'])->name('payment.failed');


//protected routes
Route::middleware(['auth.admin'])->group(function () {
    Route::post('/logout',  [AuthController::class, 'logout'])->name('admin.logout'); 
    Route::get('/dashboard',[HomeController::class, 'dashboard'])->name('admin.dashboard');

    // store routes //
    Route::get('/stores',               [StoreController::class, 'index'])->name('admin.stores.index');
    Route::get('/stores/{id}',          [StoreController::class, 'show'])->name('admin.stores.show');
    Route::post('/stores/{id}/activate',[StoreController::class, 'activate'])->name('admin.stores.activate');

    // order routes //
    Route::get('/orders',                 [OrderController::class,'index'])->name('admin.orders.index');
    Route::get('/orders/{id}',            [OrderController::class,'show'])->name('admin.orders.show');
    Route::put('/assign-delegate/{order}',[OrderController::class,'assignDelegate'])->name('admin.orders.assign');

    // delegates routes //
    Route::get('/delegates',              [DelegateController::class,'index'])->name('admin.delegates.index');
    Route::get('/delegates/{id}',         [DelegateController::class,'show'])->name('admin.delegates.show');
    Route::delete('/delete-delegate/{id}',[DelegateController::class,'destroy'])->name('admin.delegates.destroy');
});
