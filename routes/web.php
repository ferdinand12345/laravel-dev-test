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
    return view('welcome');
});

Route::get( '/register', 'AuthController@register_form' );

Route::post( '/register', 'AuthController@register_process' );

Route::get( '/login', 'AuthController@login_process' );
Route::get( '/dashboard', 'DashboardController@index' );
Route::get( '/cs', 'AuthController@check_session' );
Route::get( '/testing', 'AuthController@testing' );