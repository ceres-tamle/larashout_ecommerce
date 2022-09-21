<?php

use App\Http\Controllers\Site\AccountController;
use App\Http\Controllers\Site\CartController;
use App\Http\Controllers\Site\CategoryController;
use App\Http\Controllers\Site\CheckoutController;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\ProductController;
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

Route::get('/', [HomeController::class, 'show']);
Route::get('/filter', [HomeController::class, 'filter'])->name('home.filter.price');
Route::get('/desc/price', [HomeController::class, 'descPrice'])->name('home.desc.price');
Route::get('/asc/price', [HomeController::class, 'ascPrice'])->name('home.asc.price');

// Category
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

// Product
Route::get('/product/{slug}', [ProductController::class, 'show'])->name('product.show');
Route::post('/product/add/cart', [ProductController::class, 'addToCart'])->name('product.add.cart');

// Cart
Route::get('/cart', [CartController::class, 'getCart'])->name('checkout.cart');
Route::get('/cart/item/{id}/remove', [CartController::class, 'removeItem'])->name('checkout.cart.remove');
Route::get('/cart/clear', [CartController::class, 'clearCart'])->name('checkout.cart.clear');

Route::group(['middleware' => ['auth']], function () {

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'getCheckout'])->name('checkout.index');
    Route::post('/checkout/order', [CheckoutController::class, 'placeOrder'])->name('checkout.place.order');
    Route::get('checkout/payment/complete', [CheckoutController::class, 'complete'])->name('checkout.payment.complete');

    // Account
    Route::get('account/orders', [AccountController::class, 'getOrders'])->name('account.orders');
});
