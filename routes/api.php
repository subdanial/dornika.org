<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::group(['middleware' => ['auth:api']], function () {
    Route::post('/removeItem', 'HomeController@removeItem')->name('removeItem');
    Route::post('/saveCart', 'HomeController@saveCart')->name('saveCart');
    Route::post('/changeItem', 'HomeController@changeItem')->name('changeItem');
    Route::post('/changeItemBox', 'HomeController@changeItemBox')->name('changeItemBox');
    Route::get('/', 'HomeController@ajax_clients')->name('userClientsIndex');
    Route::post('/store', 'HomeController@clients_store')->name('userClientsStore');
        Route::post('/update', 'HomeController@clients_update')->name('userClientsUpdate');
        Route::post('/delete', 'HomeController@clients_destroy')->name('userClientsDestroy');
});

Route::group(['prefix' => 'admin', 'middleware' => ['auth:api', 'role:admin']], function () {
    // Dashboard
    Route::group(['prefix' => 'dashboard'], function () {
        Route::get('/sales', 'DashboardController@ajax_sales')->name('ajaxSales');
        Route::get('/commissions', 'DashboardController@ajax_commissions')->name('ajaxCommissions');
        Route::get('/latest', 'DashboardController@ajax_latest')->name('ajaxLatest');
        Route::get('/visitors_number', 'DashboardController@ajax_visitors_number')->name('ajaxVisitorsNumber');
        Route::get('/clients_number', 'DashboardController@ajax_clients_number')->name('ajaxClientsNumber');
        Route::get('/total_sales', 'DashboardController@ajax_total_sales')->name('ajaxTotalSales');
        Route::get('/total_commissions', 'DashboardController@ajax_total_commissions')->name('ajaxTotalCommissions');
    });

    // Products
    Route::group(['prefix' => 'products'], function () {
        Route::get('/', 'ProductController@ajax_index')->name('productIndex');
        Route::post('/store', 'ProductController@store')->name('productCreate');
        Route::put('/update', 'ProductController@update')->name('productUpdate');
        Route::post('/delete', 'ProductController@destroy')->name('productDestroy');
    });
    
    // Users
    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UserController@ajax_index')->name('userIndex');
        Route::post('/store', 'UserController@store')->name('userCreate');
        Route::post('/update', 'UserController@update')->name('userUpdate');
        Route::post('/delete', 'UserController@destroy')->name('userDestroy');
    });
    
    // Clients
    Route::group(['prefix' => 'clients'], function () {
        Route::get('/', 'ClientController@ajax_index')->name('clientIndex');
        Route::post('/store', 'ClientController@store')->name('clientCreate');
        Route::post('/update', 'ClientController@update')->name('clientUpdate');
        Route::post('/delete', 'ClientController@destroy')->name('clientDestroy');
    });
    
    // Categories
    Route::group(['prefix' => 'categories'], function () {
        Route::get('/', 'CategoryController@ajax_index')->name('categoryIndex');
        Route::post('/store', 'CategoryController@store')->name('categoryCreate');
        Route::post('/update', 'CategoryController@update')->name('categoryUpdate');
        Route::post('/delete', 'CategoryController@destroy')->name('categoryDestroy');
    });
    
    // Carts
    Route::group(['prefix' => 'carts'], function () {
        Route::get('/', 'CartController@ajax_index')->name('cartIndex');
        Route::post('/store', 'CartController@store')->name('cartCreate');
        Route::post('/update/{id}', 'CartController@update')->name('cartUpdate');
        Route::post('/delete', 'CartController@destroy')->name('cartDestroy');
        Route::post('/return', 'CartController@orders_return')->name('cartReturn');
    });
    
    // Messages
    Route::group(['prefix' => 'messages'], function () {
        Route::get('/', 'MessageController@ajax_index')->name('messageIndex');
        Route::post('/store', 'MessageController@store')->name('messageCreate');
        Route::post('/update', 'MessageController@update')->name('messageUpdate');
        Route::post('/delete', 'MessageController@destroy')->name('messageDestroy');
    });
});
