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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'KeyController@index')->name('key.home');

Route::group(['prefix' => 'key'], function () {
    Route::get('/', 'KeyController@index')->name('key.index');
    Route::post('/generate', 'KeyController@store')->name('key.store');
});

Route::group(['prefix' => 'symmetric'], function () {
    Route::get('/', 'SyncController@index')->name('symmetric.index');
    Route::post('/encrypt', 'SyncController@encrypt')->name('symmetric.encrypt');
    Route::post('/decrypt', 'SyncController@decrypt')->name('symmetric.decrypt');
    Route::get('/decrypt', 'SyncController@index')->name('symmetric.decryptIndex');
    Route::get('/encrypt', 'SyncController@index')->name('symmetric.encriptIndex');
});

Route::group(['prefix' => 'assymmetric'], function () {
    Route::get('/', 'AsyncController@index')->name('assymmetric.index');
    Route::post('/encrypt', 'AsyncController@encrypt')->name('assymmetric.encrypt');
    Route::post('/decrypt', 'AsyncController@decrypt')->name('assymmetric.decrypt');
    Route::get('/decrypt', 'AsyncController@index')->name('assymmetric.decryptIndex');
    Route::get('/encrypt', 'AsyncController@index')->name('assymmetric.encriptIndex');
});
