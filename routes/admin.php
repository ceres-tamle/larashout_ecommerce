<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'admin'], function () {

    Route::group(['middleware' => ['auth:admin']], function () {
        Route::get('/', function () {
            return view('admin.dashboard.index');
        })->name('admin.dashboard');
        Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])->name('admin.settings');
        Route::post('/settings', [App\Http\Controllers\Admin\SettingController::class, 'update'])->name('admin.settings.update');

        Route::group(['prefix' => 'categories'], function () {
            Route::get('/', [App\Http\Controllers\CategoryController::class, 'index'])->name('admin.categories.index');
            Route::get('/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('admin.categories.create');
            Route::post('/store', [App\Http\Controllers\CategoryController::class, 'store'])->name('admin.categories.store');
            Route::get('/{id}/edit', [App\Http\Controllers\CategoryController::class, 'edit'])->name('admin.categories.edit');
            Route::post('/update', [App\Http\Controllers\CategoryController::class, 'update'])->name('admin.categories.update');
            Route::get('/{id}/delete', [App\Http\Controllers\CategoryController::class, 'delete'])->name('admin.categories.delete');
        });
    });

    Route::get('login', [App\Http\Controllers\Admin\LoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [App\Http\Controllers\Admin\LoginController::class, 'login'])->name('admin.login.post');
    Route::get('logout', [App\Http\Controllers\Admin\LoginController::class, 'logout'])->name('admin.logout');
});
