<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerProfileController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceProductController;
use App\Http\Controllers\PolicyController;
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

Route::get('/brand', [BrandController::class, 'index'])->name('brand.index');
Route::get('/brand/{id}', [BrandController::class, 'single'])->name('brand.single');

Route::get('/category', [CategoryController::class, 'index'])->name('category.index');
Route::get('/category/{id}', [CategoryController::class, 'single'])->name('category.single');

Route::get('/product-slider', [ProductSliderController::class, 'get'])->name('productSlider.get');

Route::get('/brand/{id}/product', [ProductController::class, 'indexByBrand'])->name('product.brand.index');
Route::get('/category/{id}/product', [ProductController::class, 'indexByCategory'])->name('product.category.index');
Route::get('/remark/{remark}/product', [ProductController::class, 'indexByRemark'])->name('product.remark.index');

Route::get('/product', [ProductController::class, 'search'])->name('product.search');
Route::get('/product/{id}', [ProductController::class, 'single'])->name('product.single');

Route::get('/product/{productID}/detail', [ProductDetailController::class, 'get'])->name('productDetail.get');
Route::get('/product/{productID}/review', [ReviewController::class, 'getProductReviews'])->name('product.review.get');

Route::get('/policy/{type}', [PolicyController::class, 'get'])->name('policy.get');

Route::post('/login', [UserController::class, 'login'])->name('login')->middleware('guest.jwt');
Route::post('/login-verify', [UserController::class, 'loginVerify'])->name('login.verify')->middleware('guest.jwt');

Route::post('/profile', [CustomerProfileController::class, 'save'])->name('profile.save')->middleware('auth.jwt');
Route::get('/profile', [CustomerProfileController::class, 'getProfile'])->name('profile.get')->middleware('auth.jwt');

Route::post('/user/review', [ReviewController::class, 'save'])->name('review.save')->middleware('auth.jwt');
Route::get('/user/review/{productId}', [ReviewController::class, 'getReviewByCustomer'])->name('user.review.get')->middleware('auth.jwt');
Route::get('/user/review', [ReviewController::class, 'getAllReviewsByCustomer'])->name('user.review.getAll')->middleware('auth.jwt');
Route::get('/user/to-review', [ReviewController::class, 'getToReviewProducts'])->name('user.toReview')->middleware('auth.jwt');

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
Route::get('/invoice-detail/{id}', [InvoiceProductController::class, 'get'])->name('invoiceDetail.get')->middleware('auth.jwt');

Route::get('/logout', [UserController::class, 'logout'])->name('logout')->middleware('auth.jwt');

Route::post('/payment-success/{transactionID}/{frontEnd}', [InvoiceController::class, 'paymentSuccess'])->name('paymentSuccess');
Route::post('/payment-fail/{transactionID}/{frontEnd}', [InvoiceController::class, 'paymentFail'])->name('paymentFail');
Route::post('/payment-cancel/{transactionID}/{frontEnd}', [InvoiceController::class, 'paymentCancel'])->name('paymentCancel');
Route::post('/ipn', [InvoiceController::class, 'handleIPN'])->name('ipn');
