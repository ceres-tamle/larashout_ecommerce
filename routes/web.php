<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

require 'admin.php';

Route::get('/', [App\Http\Controllers\Site\HomeController::class, 'show']);
Route::get('/desc/price', [App\Http\Controllers\Site\HomeController::class, 'descPrice'])->name('home.desc.price');
Route::get('/asc/price', [App\Http\Controllers\Site\HomeController::class, 'ascPrice'])->name('home.asc.price');

// Category
Route::get('/category/{slug}', [App\Http\Controllers\Site\CategoryController::class, 'show'])->name('category.show');

// Product
Route::get('/product/{slug}', [App\Http\Controllers\Site\ProductController::class, 'show'])->name('product.show');
Route::post('/product/add/cart', [App\Http\Controllers\Site\ProductController::class, 'addToCart'])->name('product.add.cart');

// Cart
Route::get('/cart', [App\Http\Controllers\Site\CartController::class, 'getCart'])->name('checkout.cart');
Route::get('/cart/item/{id}/remove', [App\Http\Controllers\Site\CartController::class, 'removeItem'])->name('checkout.cart.remove');
Route::get('/cart/clear', [App\Http\Controllers\Site\CartController::class, 'clearCart'])->name('checkout.cart.clear');

Route::group(['middleware' => ['auth']], function () {

    // Checkout
    Route::get('/checkout', [App\Http\Controllers\Site\CheckoutController::class, 'getCheckout'])->name('checkout.index');
    Route::post('/checkout/order', [App\Http\Controllers\Site\CheckoutController::class, 'placeOrder'])->name('checkout.place.order');
    Route::get('checkout/payment/complete', [App\Http\Controllers\Site\CheckoutController::class, 'complete'])->name('checkout.payment.complete');

    // Account
    Route::get('account/orders', [App\Http\Controllers\Site\AccountController::class, 'getOrders'])->name('account.orders');
});
