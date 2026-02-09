<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PromotionalController;
use App\Http\Controllers\Api\CmsController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\AddressController;
use App\Http\Controllers\Api\SupportController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\WishlistController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forget/password', [AuthController::class, 'forgotPassword']);
Route::post('/verify/email', [AuthController::class, 'verifyEmail']);

// Category
Route::get('/category', [CategoryController::class, 'category']);
Route::get('/category-subcategory', [CategoryController::class, 'categorySubcategory']);
Route::get('/sub-category/{id?}', [CategoryController::class, 'subCategory']);
Route::get('/brands', [CategoryController::class, 'brands']);

// Sliders
Route::get('/slider', [SliderController::class, 'slider']);

// Products
Route::get('/products', [ProductController::class, 'products']);
Route::get('/summer-products/{id}', [ProductController::class, 'summerProducts']);
Route::get('/category-products/{id}', [ProductController::class, 'categoryProducts']);
Route::get('/all-products', [ProductController::class, 'allProducts']);
Route::get('/products/{url}', [ProductController::class, 'productsDetails']);

// Promotional
Route::get('/promotionals', [PromotionalController::class, 'promotional']);

// CMS
Route::get('/cms', [CmsController::class, 'cms']);

// Settings
Route::get('/setting/{name}', [SettingController::class, 'setting']);
Route::get('/settings', [SettingController::class, 'settings']);

// Support
Route::get('/support/country', [SupportController::class, 'country']);
Route::get('/support/state/{countryID}', [SupportController::class, 'state']);
Route::get('/support/district/{stateID}', [SupportController::class, 'district']);
Route::get('/support/tehsil/{districtID}', [SupportController::class, 'tehsil']);
Route::get('/support/block/{tehsilID}', [SupportController::class, 'block']);
Route::get('/support/village/{blockID}', [SupportController::class, 'village']);

// Authenticate Page
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // address
    Route::post('/add-new-address', [AddressController::class, 'addAddress']);
    Route::post('/update-address', [AddressController::class, 'updateAddress']);
    Route::delete('/delete-address', [AddressController::class, 'deleteAddress']);
    Route::get('/user-address', [AddressController::class, 'userAddress']);
    Route::get('/change-address', [AddressController::class, 'changeAddress']);

    Route::prefix('cart')->controller(CartController::class)->group(function(){
        Route::get('/', 'index');
        Route::post('/add', 'add');
        Route::get('/remove', 'remove');
    });

    Route::prefix('wishlist')->controller(WishlistController::class)->group(function(){
        Route::get('/', 'index');
        Route::post('/add', 'add');
        Route::get('/remove', 'remove');
    });
});
