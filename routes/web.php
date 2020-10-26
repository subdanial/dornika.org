<?php

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



Route::get('/categories/{category?}/{sub_category?}', 'HomeController@categories')->name('categories');
Route::get('/', 'HomeController@index')->name('index');
Route::group(['prefix' => 'dashboard', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@home')->name('home');
    Route::get('/products/{slug}', 'HomeController@single')->name('products.single');
    Route::get('/products/{slug}/reset', 'HomeController@reset')->name('products.reset');
    Route::post('/products/{slug}', 'HomeController@order')->name('products.order');
    Route::post('/products/{slug}/fake_price', 'HomeController@fake_price')->name('products.fake_price');
    Route::get('/cart', 'HomeController@cart')->name('cart');
    Route::get('/messages', 'HomeController@messages')->name('messages');
    Route::get('/clients', 'HomeController@clients')->name('clients');
    Route::get('/orders', 'HomeController@orders')->name('orders');
    Route::post('/orders/cancel', 'HomeController@orders_cancel')->name('orders_cancel');
    Route::post('/orders/return', 'HomeController@orders_return')->name('orders_return');
    Route::get('/profile/{username}', 'HomeController@profile')->name('profile');
    Route::group(['prefix' => 'archives', 'name' => 'archives'], function () {
        Route::get('/best-selling', 'HomeController@selling')->name('selling');
        Route::get('/most-viewed', 'HomeController@viewed')->name('viewed');
        Route::get('/latest', 'HomeController@latest')->name('latest');
    });
    Route::post('/saveSettings', 'HomeController@saveSettings')->name('saveSettings');
});



Route::group(['prefix' => 'admin', 'middleware' => ['role:admin']], function () {
    // Dashboard
    Route::get('/', 'DashboardController@index');
    
    // Products
    Route::resource('products', 'ProductController');
    
    // Users
    Route::resource('visitors', 'UserController');
    
    // Clients
    Route::resource('clients', 'ClientController');
    
    // Categories
    Route::resource('categories', 'CategoryController');
    
    // Carts
    Route::get('/orders/{cart}/invoice', 'CartController@invoice')->name('invoice');
    Route::post('/orders/changeDelivery', 'CartController@delivery')->name('changeDelivery');
    Route::resource('orders', 'CartController');
    
    // Messages
    Route::resource('messages', 'MessageController');
});
