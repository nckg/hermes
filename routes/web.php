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
    Route::get('documents/{id}', 'DocumentsController@show')->name('documents.show');
    Route::get('media/{id}', 'MediaController@show')->name('media.show');

    Route::name('api::')->namespace('Api')->prefix('api')->group(function() {
        Route::get('documents', 'DocumentsController@index')->name('documents.index');
        Route::delete('documents', 'DocumentsController@destroy')->name('documents.destroy');
        Route::post('export-documents', 'ExportDocumentsController@store')->name('export.store');
    });
});

