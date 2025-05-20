<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\AuthController;
use App\Http\Controllers\Api\User\CartController;
use App\Http\Controllers\Api\User\HomeController;
use App\Http\Controllers\Api\User\ProfileController;
use App\Http\Controllers\Api\User\OrderController;
use App\Http\Controllers\Api\User\ResetPasswordController;
use App\Http\Controllers\Api\User\AddressController;
use App\Http\Controllers\Api\User\StoreController;
use App\Services\PaymentGateway\PaymentService;
use App\Http\Controllers\Api\User\ReviewController;


Route::post('/register-super', 'App\Http\Controllers\Super\AuthController@register');

//////////////////////////////////////// User Routes ////////////////////////////////////////
//public routes
Route::post('/register',     [AuthController::class, 'register']);
Route::post('/verify-email', [AuthController::class, 'verifyEmail']);
Route::post('/resend-code',  [AuthController::class, 'resendCode']);
Route::post('/login',        [AuthController::class, 'login']);
Route::post('/google-login', [AuthController::class, 'googleLogin']);

Route::get('payment/get-payment-status'     ,[PaymentService::class, 'callback'])->name('payment.getPaymentStatus');

// reset password //
Route::post('/reset-password-send-code'     ,[ResetPasswordController::class, 'sendCode']);
Route::post('/reset-password-check-code'    ,[ResetPasswordController::class, 'checkCode']);
Route::post('/reset-password'               ,[ResetPasswordController::class, 'resetPassword']);

// home routes //
Route::get('/banners',            [HomeController::class, 'banners']);
Route::get('/categories'     ,    [HomeController::class, 'categories']);
Route::get('/offers',             [HomeController::class, 'latestStoresWithOffers']);
Route::get('/closest-stores',     [HomeController::class, 'closestStores']);

// stores routes //
Route::get('/stores/{categoryId}',  [StoreController::class, 'getStoreByCategory']);
Route::get('/best-stores',          [StoreController::class, 'bestStores']);
Route::get('/store/{storeId}',      [StoreController::class, 'getStoreById']);
Route::get('/products/{categoryId}',[StoreController::class, 'getProductsByCategory']);
Route::get('/product/{productId}',  [StoreController::class, 'productById']);
Route::get('/frequent-products',    [StoreController::class, 'frequentProducts']);



//protected routes
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('set-location', [AuthController::class, 'setLocation']);
    Route::post('/logout',      [AuthController::class, 'logout']);

    // review routes //
    Route::post('/add-review',      [ReviewController::class, 'addReview']);
    Route::get('/reviews/{storeId}',[ReviewController::class, 'getStoreReviews']);

    // profile routes //
    Route::get('/get-profile',      [ProfileController::class, 'getProfile']);
    Route::post('/update-profile',  [ProfileController::class, 'updateProfile']);
    Route::post('/delete-account',  [ProfileController::class, 'deleteAccount']);
    Route::post('/change-password', [ProfileController::class, 'changePassword']);
    Route::post('/update-location', [ProfileController::class, 'updateLocation']);
    Route::get('/export-code',      [ProfileController::class, 'exportReferralCode']);
    Route::post('/enable-notifications', [ProfileController::class, 'enableNotifications']);

    // cart routes //
    Route::post('/add-to-cart'              ,[CartController::class , 'addToCart']);
    Route::get('/cart-summary'              ,[CartController::class , 'cartSummary']);
    Route::post('/update-cart'              ,[CartController::class , 'updateCart']);
    Route::post('delete-cart'               ,[CartController::class , 'deleteCart']);
    Route::post('delete-all-carts'          ,[CartController::class , 'deleteAllCarts']);

    // order routes //
    Route::post('store-order'               ,[OrderController::class, 'store']);
    Route::get('orders'                     ,[OrderController::class, 'orders']);
    Route::get('orders/{order}'             ,[OrderController::class, 'showOrder']);

    // Address Routes //
    Route::get('/addresses'                  ,[AddressController::class, 'index']);
    Route::post('/store-address'             ,[AddressController::class, 'store']);
    Route::delete('/delete-address/{id}'     ,[AddressController::class, 'destroy']);

});