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

Route::get('/', function () {
    return view('home');
});

Route::get('/register', function() {
    return view('register');
});

Route::get('/login', function() {
    return view('login');
});

Route::post('/register', 'Users@register');
Route::post('/login', 'Users@login');

Route::get('/r/{hash}', 'Link@redirect');
Route::get('/d/{hash}', 'Dashboard@view');
