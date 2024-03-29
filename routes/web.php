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

Route::get( '/', 'ContactsController@index' );
Route::get( '/contacts', 'ContactsController@index' );
Route::get( '/contacts/create', 'ContactsController@create_form' );
Route::post( '/contacts/create', 'ContactsController@create_process' );
Route::post( '/contacts/data', 'ContactsController@data' );
Route::get( '/contacts/data-group', 'ContactsController@data_group' );
Route::post( '/contacts/delete', 'ContactsController@delete_process' );
Route::get( '/contacts/detail/{ID}', 'ContactsController@data_detail' );
Route::get( '/contacts/edit/{ID}', 'ContactsController@edit_form' );
Route::post( '/contacts/edit/{ID}', 'ContactsController@edit_process' );