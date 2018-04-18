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

Route::get('/', 'Auth\LoginController@showLoginForm');

Auth::routes();

Route::group(config('route.admin'), function () {
    Route::get('home', function () {
        return redirect()->route('documents.index');
    });
    Route::get('documents', 'DocumentsController@index')->name('documents.index');
    Route::post('documents', 'DocumentsController@store')->name('documents.store');
    Route::get('documents/create', 'DocumentsController@create')->name('documents.create');
    Route::get('documents/{id}', 'DocumentsController@show')->name('documents.show');
});

