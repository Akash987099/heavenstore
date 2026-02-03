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
use App\Models\Setting;

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

// Promotional
Route::get('/promotionals', [PromotionalController::class, 'promotional']);

// CMS
Route::get('/cms', [CmsController::class, 'cms']);

// Settings
Route::get('/setting/{name}', [SettingController::class, 'setting']);
Route::get('/settings', [SettingController::class, 'settings']);

// Authenticate Page
Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // address
    Route::post('/add/address', [UserController::class, 'addAddress']);
});
