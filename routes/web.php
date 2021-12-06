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
    return view('auth.login');
});

// Auth::routes(['register' => false]);
Auth::routes([
    'register' => false, // Registration Routes...
    'reset' => false, // Password Reset Routes...
    'verify' => false, // Email Verification Routes...
]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/user', 'UserController@index')->name('user');
Route::post('/user/store', 'UserController@store')->name('user.store');
Route::get('/user/edit/{id}', 'UserController@edit')->name('user.edit');
Route::post('/user/update/{id}', 'UserController@update')->name('user.update');
Route::get('/user/delete/{id}', 'UserController@delete')->name('user.delete');

Route::get('/unit', 'UnitController@index')->name('unit');
Route::post('/unit/store', 'UnitController@store')->name('unit.store');
Route::get('/unit/edit/{id}', 'UnitController@edit')->name('unit.edit');
Route::post('/unit/update/{id}', 'UnitController@update')->name('unit.update');
Route::get('/unit/delete/{id}', 'UnitController@delete')->name('unit.delete');

Route::get('/tahun', 'TahunController@index')->name('tahun');
Route::post('/tahun/store', 'TahunController@store')->name('tahun.store');
// Route::get('/tahun/edit/{id}', 'TahunController@edit')->name('tahun.edit');
// Route::post('/tahun/update/{id}', 'TahunController@update')->name('tahun.update');
Route::get('/tahun/delete/{id}', 'TahunController@delete')->name('tahun.delete');

Route::get('/lokal', 'LokalController@index')->name('lokal');
Route::post('/lokal/store', 'LokalController@store')->name('lokal.store');

Route::get('/lokal/{id}', 'DetailLokalController@index')->name('detaillokal');
Route::post('/lokal/detail/store', 'DetailLokalController@store')->name('detaillokal.store');
