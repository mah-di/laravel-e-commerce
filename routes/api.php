<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\ProductSliderController;
use App\Http\Controllers\ReviewController;
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
Route::get('/brands/{id}/products', [ProductController::class, 'indexByBrand'])->name('product.brand.index');
Route::get('/categories/{id}/products', [ProductController::class, 'indexByCategory'])->name('product.category.index');
Route::get('/{remark}/products', [ProductController::class, 'indexByRemark'])->name('product.remark.index');
Route::get('/products', [ProductController::class, 'search'])->name('product.search');
Route::get('/products/{id}', [ProductController::class, 'single'])->name('product.single');
Route::get('/product-sliders', [ProductSliderController::class, 'get'])->name('productSlider.get');
Route::get('/product-details/{id}', [ProductDetailController::class, 'get'])->name('productDetail.get');
Route::get('/reviews/{id}', [ReviewController::class, 'get'])->name('review.get');
