<?php

use App\Http\Controllers\Admin\OrderController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

Route::group(['prefix' => 'admin'], function () {

    Route::get('login', [App\Http\Controllers\Admin\LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [App\Http\Controllers\Admin\LoginController::class, 'login'])->name('admin.login.post');
    Route::get('logout', [App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('admin.logout');

    Route::group(['middleware' => ['auth:admin']], function () {

        Route::get('/', function () {
            return view('admin.dashboard.index');
        })->name('admin.dashboard');

        Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings');
        Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');

        Route::group(['prefix' => 'categories'], function () {

            Route::get('/', [App\Http\Controllers\Admin\CategoryController::class, 'index'])->name('admin.categories.index');
            Route::get('/create', [App\Http\Controllers\Admin\CategoryController::class, 'create'])->name('admin.categories.create');
            Route::post('/store', [App\Http\Controllers\Admin\CategoryController::class, 'store'])->name('admin.categories.store');
            Route::get('/{id}/edit', [App\Http\Controllers\Admin\CategoryController::class, 'edit'])->name('admin.categories.edit');
            Route::post('/update', [App\Http\Controllers\Admin\CategoryController::class, 'update'])->name('admin.categories.update');
            Route::get('/{id}/delete', [App\Http\Controllers\Admin\CategoryController::class, 'delete'])->name('admin.categories.delete');
        });

        Route::group(['prefix' => 'attributes'], function () {

            Route::get('/', [App\Http\Controllers\Admin\AttributeController::class, 'index'])->name('admin.attributes.index');
            Route::get('/create', [App\Http\Controllers\Admin\AttributeController::class, 'create'])->name('admin.attributes.create');
            Route::post('/store', [App\Http\Controllers\Admin\AttributeController::class, 'store'])->name('admin.attributes.store');
            Route::get('/{id}/edit', [App\Http\Controllers\Admin\AttributeController::class, 'edit'])->name('admin.attributes.edit');
            Route::post('/update', [App\Http\Controllers\Admin\AttributeController::class, 'update'])->name('admin.attributes.update');
            Route::get('/{id}/delete', [App\Http\Controllers\Admin\AttributeController::class, 'delete'])->name('admin.attributes.delete');

            Route::post('/get-values', [App\Http\Controllers\Admin\AttributeValueController::class, 'getValues']);
            Route::post('/add-values', [App\Http\Controllers\Admin\AttributeValueController::class, 'addValues']);
            Route::post('/update-values', [App\Http\Controllers\Admin\AttributeValueController::class, 'updateValues']);
            Route::post('/delete-values', [App\Http\Controllers\Admin\AttributeValueController::class, 'deleteValues']);
        });

        Route::group(['prefix' => 'brands'], function () {

            Route::get('/', [App\Http\Controllers\Admin\BrandController::class, 'index'])->name('admin.brands.index');
            Route::get('/create', [App\Http\Controllers\Admin\BrandController::class, 'create'])->name('admin.brands.create');
            Route::post('/store', [App\Http\Controllers\Admin\BrandController::class, 'store'])->name('admin.brands.store');
            Route::get('/{id}/edit', [App\Http\Controllers\Admin\BrandController::class, 'edit'])->name('admin.brands.edit');
            Route::post('/update', [App\Http\Controllers\Admin\BrandController::class, 'update'])->name('admin.brands.update');
            Route::get('/{id}/delete', [App\Http\Controllers\Admin\BrandController::class, 'delete'])->name('admin.brands.delete');
        });

        Route::group(['prefix' => 'products'], function () {

            Route::get('/', [App\Http\Controllers\Admin\ProductController::class, 'index'])->name('admin.products.index');
            Route::get('/create', [App\Http\Controllers\Admin\ProductController::class, 'create'])->name('admin.products.create');
            Route::post('/store', [App\Http\Controllers\Admin\ProductController::class, 'store'])->name('admin.products.store');
            Route::get('/edit/{id}', [App\Http\Controllers\Admin\ProductController::class, 'edit'])->name('admin.products.edit');
            Route::post('/update', [App\Http\Controllers\Admin\ProductController::class, 'update'])->name('admin.products.update');
            Route::post('images/upload', [App\Http\Controllers\Admin\ProductImageController::class, 'upload'])->name('admin.products.images.upload');
            Route::get('images/{id}/delete', [App\Http\Controllers\Admin\ProductImageController::class, 'delete'])->name('admin.products.images.delete');

            // Load attributes on the page load
            Route::get('attributes/load', [App\Http\Controllers\Admin\ProductAttributeController::class, 'loadAttributes']);
            // Load product attributes on the page load
            Route::post('attributes', [App\Http\Controllers\Admin\ProductAttributeController::class, 'productAttributes']);
            // Load option values for a attribute
            Route::post('attributes/values', [App\Http\Controllers\Admin\ProductAttributeController::class, 'loadValues']);
            // Add product attribute to the current product
            Route::post('attributes/add', [App\Http\Controllers\Admin\ProductAttributeController::class, 'addAttribute']);
            // Delete product attribute from the current product
            Route::post('attributes/delete', [App\Http\Controllers\Admin\ProductAttributeController::class, 'deleteAttribute']);
        });

        Route::group(['prefix' => 'orders'], function () {

            Route::get('/', [OrderController::class, 'index'])->name('admin.orders.index');
            Route::get('/create', [OrderController::class, 'create'])->name('admin.orders.create');
            Route::post('/store', [OrderController::class, 'store'])->name('admin.orders.store');
            Route::get('/edit/{id}', [OrderController::class, 'edit'])->name('admin.orders.edit');
            Route::post('/update', [OrderController::class, 'update'])->name('admin.orders.update');
            Route::get('/delete/{id}', [OrderController::class, 'delete'])->name('admin.orders.delete');
        });

        Route::group(['prefix' => 'users'], function () {

            Route::get('/', [UserController::class, 'index'])->name('admin.users.index');
            Route::get('/create', [UserController::class, 'create'])->name('admin.users.create');
            Route::post('/store', [UserController::class, 'store'])->name('admin.users.store');
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('admin.users.edit');
            Route::post('/update', [UserController::class, 'update'])->name('admin.users.update');
            Route::get('/delete/{id}', [UserController::class, 'delete'])->name('admin.users.delete');
        });
    });
});
