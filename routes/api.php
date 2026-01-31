<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\SliderController;
use App\Http\Controllers\Api\ProductController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::post('/resend-otp', [AuthController::class, 'resendOtp']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/forget/password', [AuthController::class, 'forgotPassword']);
Route::post('/verify/email', [AuthController::class, 'verifyEmail']);

Route::get('/category', [CategoryController::class, 'category']);
Route::get('/category-subcategory', [CategoryController::class, 'categorySubcategory']);
Route::get('/sub-category/{id?}', [CategoryController::class, 'subCategory']);
Route::get('/brands', [CategoryController::class, 'brands']);

// Sliders

Route::get('/slider', [SliderController::class, 'slider']);
Route::get('/products', [ProductController::class, 'products']);
Route::get('/summer-products/{id}', [ProductController::class, 'summerProducts']);
Route::get('/category-products/{id}', [ProductController::class, 'categoryProducts']);
Route::get('/all-products', [ProductController::class, 'allProducts']);

Route::middleware('auth:api')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // address
    Route::post('/add/address', [UserController::class, 'addAddress']);
});
