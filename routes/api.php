<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\ProductSliderController;
use App\Http\Controllers\ProductWishController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/brands', [BrandController::class, 'index'])->name('brand.index');
Route::get('/categories', [CategoryController::class, 'index'])->name('category.index');
Route::get('/product-sliders', [ProductSliderController::class, 'get'])->name('productSlider.get');
Route::get('/brands/{id}/products', [ProductController::class, 'indexByBrand'])->name('product.brand.index');
Route::get('/categories/{id}/products', [ProductController::class, 'indexByCategory'])->name('product.category.index');
Route::get('/remark/{remark}/products', [ProductController::class, 'indexByRemark'])->name('product.remark.index');
Route::get('/products', [ProductController::class, 'search'])->name('product.search');
Route::get('/products/{id}', [ProductController::class, 'single'])->name('product.single');
Route::get('/products/{productID}/details', [ProductDetailController::class, 'get'])->name('productDetail.get');
Route::get('/products/{productID}/reviews', [ReviewController::class, 'getProductReviews'])->name('product.review.get');

Route::post('/login', [UserController::class, 'login'])->name('login')->middleware('guest.jwt');
Route::post('/login-verify', [UserController::class, 'loginVerify'])->name('login.verify')->middleware('guest.jwt');

Route::post('/profile', [CustomerProfileController::class, 'save'])->name('profile.save')->middleware('auth.jwt');
Route::get('/profile', [CustomerProfileController::class, 'getProfile'])->name('profile.get')->middleware('auth.jwt');

Route::post('/review', [ReviewController::class, 'save'])->name('review.save')->middleware('auth.jwt');
Route::get('/user/reviews/{id}', [ReviewController::class, 'getReviewByCustomer'])->name('user.review.get')->middleware('auth.jwt');
Route::get('/user/reviews', [ReviewController::class, 'getAllReviewsByCustomer'])->name('user.review.getAll')->middleware('auth.jwt');

Route::get('/user/wish/{id}', [ProductWishController::class, 'save'])->name('productWish.save')->middleware('auth.jwt');
Route::get('/user/wish', [ProductWishController::class, 'get'])->name('productWish.get')->middleware('auth.jwt');
Route::delete('/user/wish/{id}', [ProductWishController::class, 'delete'])->name('productWish.delete')->middleware('auth.jwt');
Route::delete('/user/wish', [ProductWishController::class, 'clear'])->name('productWish.clear')->middleware('auth.jwt');

Route::post('/user/cart', [CartController::class, 'save'])->name('cart.save')->middleware('auth.jwt');
Route::get('/user/cart', [CartController::class, 'get'])->name('cart.get')->middleware('auth.jwt');
Route::delete('/user/cart/{id}', [CartController::class, 'delete'])->name('cart.delete')->middleware('auth.jwt');
Route::delete('/user/cart', [CartController::class, 'clear'])->name('cart.clear')->middleware('auth.jwt');

Route::get('/invoice/place', [InvoiceController::class, 'create'])->name('invoice.create')->middleware('auth.jwt');
Route::get('/invoice', [InvoiceController::class, 'getAll'])->name('invoice.getAll')->middleware('auth.jwt');
Route::get('/invoice/{id}', [InvoiceController::class, 'get'])->name('invoice.get')->middleware('auth.jwt');

Route::post('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth.jwt');

Route::post('/payment-success/{transactionID}', [InvoiceController::class, 'paymentSuccess'])->name('paymentSuccess');
Route::post('/payment-fail/{transactionID}', [InvoiceController::class, 'paymentFail'])->name('paymentFail');
Route::post('/payment-cancel/{transactionID}', [InvoiceController::class, 'paymentCancel'])->name('paymentCancel');
Route::post('/ipn', [InvoiceController::class, 'handleIPN'])->name('ipn');
