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


Route::group(['middleware' => 'admin'], function () {
    Route::get('/admin', 'AdminController@index')->name('admin');

    Route::get('/admin/products', 'AdminController@products')->name('admin.products');
    Route::post('/admin/products', 'ProductController@store')->name('admin.products.store');
    Route::delete('/admin/products/{product}', 'PlanController@destroy')->name('admin.products.delete');

    Route::get('/admin/plans', 'AdminController@plans')->name('admin.plans');
    Route::get('/admin/plans/{plan}/edit', 'AdminController@planEdit')->name('admin.plans.edit.view');
    Route::post('/admin/plans', 'PlanController@store')->name('admin.plans.store');
    Route::delete('/admin/plans/{plan}', 'PlanController@destroy')->name('admin.plans.delete');
    Route::patch('/admin/plans/{plan}/edit', 'PlanController@edit')->name('admin.plans.edit');


    Route::get('/admin/features', 'AdminController@features')->name('admin.features');
    Route::post('/admin/features', 'FeatureController@store')->name('admin.features.store');
    Route::delete('/admin/features/{feature}', 'FeatureController@destroy')->name('admin.features.delete');


    Route::get('/admin/orders', 'AdminController@orders')->name('admin.orders');
    Route::get('/admin/users', 'AdminController@users')->name('admin.users');

});

Route::group(['middleware' => 'auth'], function () {
    Route::post('/plans/subscribe', 'PlanController@subscribe')->name('plans.subscribe');
    Route::post('/plans/change', 'PlanController@change')->name('plans.change');

    Route::get('/profile', 'UserController@view')->name('profile.view');
    Route::post('/profile', 'UserController@edit')->name('profile.edit');
    Route::get('/invoice/{invoice_id}', 'UserController@invoice');

    Route::group(['middleware' => 'features'], function() {
        // @TODO Napravi da features ide preko slug-a
        Route::group(['features' => ['dashboard']], function() {
            Route::get('/dashboard', 'DashboardController@index')->name('dashboard.home');
            Route::get('/dashboard/{link}', 'DashboardController@show')->name('dashboard.link.show');
            Route::get('/link/stats/{link}', 'LinkController@linkVisits')->name('link.stats');
            Route::delete('/link/{link}', 'LinkController@destroy')->name('link.delete');
        });
    });

});

Auth::routes();

Route::post('/link', 'LinkController@store')->name('links.store');

Route::get('/', 'HomeController@index')->name('home');



// This must be at the end
Route::get('/{link}', 'LinkController@redirect');