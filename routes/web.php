<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'pages.home-page');
Route::view('/category', 'pages.product-by-category')->name('category.page');
Route::view('/brand', 'pages.product-by-brand')->name('brand.page');
Route::view('/details', 'pages.details-page')->name('product.page');
Route::view('/policy', 'pages.policy-page')->name('policy.page');
Route::view('/login', 'pages.login-page')->name('login.page');
Route::view('/verify-otp', 'pages.verify-page')->name('loginVerify.page');

Route::view('/profile', 'pages.profile-page')->name('profile.page');
Route::view('/wish', 'pages.wish-list-page')->name('wish.page');
Route::view('/cart', 'pages.cart-list-page')->name('cart.page');
