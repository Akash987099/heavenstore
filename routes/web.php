<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DiscountController;
use App\Http\Controllers\StoreController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\TehsilController;
use App\Http\Controllers\BlockController;
use App\Http\Controllers\VillageController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\SummerController;

Route::controller(LoginController::class)->group(function () {
    Route::get('login', 'login')->name('login');
    Route::post('logins', 'logins')->name('logins');
});

Route::middleware(['auth:admin'])->group(function () {

    Route::controller(AdminController::class)->group(function () {
        Route::get('', 'index')->name('index');
    });

    Route::prefix('users')->controller(UserController::class)->name('users.')->group(function () {
        Route::get('', 'index')->name('index');
    });

    Route::prefix('categories')->controller(CategoryController::class)->name('category.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        route::post('update', 'update')->name('update');
    });

    Route::prefix('sub/category')->controller(SubCategoryController::class)->name('sub_category.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        route::post('update', 'update')->name('update');
    });

    Route::prefix('brands')->controller(BrandController::class)->name('brand.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        route::post('update', 'update')->name('update');
    });

    Route::prefix('discount')->controller(DiscountController::class)->name('discount.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        route::post('update', 'update')->name('update');
    });

    Route::prefix('products')->controller(ProductController::class)->name('product.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('status', 'status')->name('status');
        route::post('update', 'update')->name('update');
        // Gallery
        route::get('gallery/{id}', 'gallery')->name('gallery');
        route::post('gallery_save', 'gallery_save')->name('gallery_save');
        route::delete('gallery_delete/{id}', 'gallery_delete')->name('gallery_delete');
        // Stock
        route::get('stock/{id}', 'stock')->name('stock');
        route::post('stock_save', 'stockSave')->name('stock_save');
        route::post('select_stock', 'selectStock')->name('select_stock');
        route::post('summer_status', 'summerStatus')->name('summer_status');
    });

    Route::prefix('stores')->controller(StoreController::class)->name('store.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        route::post('update', 'update')->name('update');
    });

    Route::prefix('country')->controller(CountryController::class)->name('country.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('state')->controller(StateController::class)->name('state.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('district')->controller(DistrictController::class)->name('district.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('tehsil')->controller(TehsilController::class)->name('tehsil.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('store', 'store')->name('store');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('block')->controller(BlockController::class)->name('block.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('village')->controller(VillageController::class)->name('village.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('tax')->controller(TaxController::class)->name('tax.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        Route::post('update', 'update')->name('update');
        Route::post('status', 'status')->name('status');
        Route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('setting')->controller(SettingController::class)->name('setting.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        route::post('update', 'update')->name('update');
        route::delete('delete', 'delete')->name('delete');
    });

    Route::prefix('email/template')->controller(EmailTemplateController::class)->name('email_template.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        route::post('update', 'update')->name('update');
        route::delete('delete', 'delete')->name('delete');
    });

    Route::prefix('sliders')->controller(SliderController::class)->name('slider.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        route::post('update', 'update')->name('update');
        route::post('status', 'status')->name('status');
        route::delete('delete/{id}', 'delete')->name('delete');
    });

    Route::prefix('summer')->controller(SummerController::class)->name('summer.')->group(function () {
        Route::get('', 'index')->name('index');
        Route::get('add', 'add')->name('add');
        Route::post('save', 'save')->name('save');
        Route::get('edit/{id}', 'edit')->name('edit');
        route::post('update', 'update')->name('update');
    });

});
