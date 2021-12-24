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

// use Illuminate\Routing\Route;

Route::get('/', function () {
    return view('auth.login2');
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

Route::get('/profile', 'UserController@profile')->name('user.profile');
Route::post('/profile/update', 'UserController@profileupdate')->name('user.profileupdate');
Route::post('/profile/password', 'UserController@password')->name('user.password');

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

Route::get('/kategori', 'KategoriController@index')->name('kategori.index');
Route::post('/kategori/store', 'KategoriController@store')->name('kategori.store');
Route::get('/kategori/edit/{id}', 'KategoriController@edit')->name('kategori.edit');
Route::post('/kategori/update/{id}', 'KategoriController@update')->name('kategori.update');
Route::get('/kategori/delete/{id}', 'KategoriController@delete')->name('kategori.delete');

Route::get('/satuan', 'SatuanController@index')->name('satuan.index');
Route::post('/satuan/store', 'SatuanController@store')->name('satuan.store');
Route::get('/satuan/edit/{id}', 'SatuanController@edit')->name('satuan.edit');
Route::post('/satuan/update/{id}', 'SatuanController@update')->name('satuan.update');
Route::get('/satuan/delete/{id}', 'SatuanController@delete')->name('satuan.delete');

Route::get('/indikator', 'IndikatorController@index')->name('indikator');
Route::post('/indikator/store', 'IndikatorController@store')->name('indikator.store');
Route::get('/indikator/approval', 'IndikatorController@approval')->name('indikator.approval');

Route::get('/indikator/list', 'ListIndikatorController@index')->name('listindikator');
Route::post('/indikator/list/store', 'ListIndikatorController@store')->name('listindikator.store');

Route::get('/indikator/report', 'RekapController@index')->name('rekap');
Route::get('/indikator/report/month', 'RekapController@month')->name('rekap.month');

Route::get('/indikator/{id}', 'DetailIndikatorController@index')->name('detailindikator');
Route::post('/indikator/detail/store', 'DetailIndikatorController@store')->name('detailindikator.store');
Route::get('/indikator/detail/edit/{id}', 'DetailIndikatorController@edit')->name('detailindikator.edit');
Route::post('/indikator/detail/update/{id}', 'DetailIndikatorController@update')->name('detailindikator.update');
Route::get('/indikator/detail/delete/{id}', 'DetailIndikatorController@delete')->name('detailindikator.delete');
Route::get('/indikator/detail/send/{id}', 'DetailIndikatorController@send')->name('detailindikator.send');
Route::get('/indikator/approval/{id}', 'DetailIndikatorController@detail')->name('detailindikator.detail');
Route::post('/indikator/approval/{id}', 'DetailIndikatorController@approved')->name('detailindikator.approved');
