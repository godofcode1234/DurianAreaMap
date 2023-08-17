<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'WelcomeController@index');

// Các route của User
Route::get('/admin', 'AdminController@index')->name('admin');
Route::get('admin/account/create', 'AdminController@create');
Route::post('admin/account/create', 'AdminController@add');
Route::get('/admin/account/{id}/edit', 'AdminController@edit');
Route::post('/admin/account/update', 'AdminController@update');
Route::get('/admin/account/{id}/delete', 'AdminController@destroy');
Route::get('/admin/account/profile', 'AdminController@show')->name('profile');
Route::post('/update-profile', 'AdminController@update_profile');
Route::get('/reset-password','AdminController@create_password');
Route::post('/reset-password','AdminController@reset_password');


// Các route của District
Route::get('/admin/district', 'DistrictController@index')->name('district');
Route::get('/admin/district/create', 'DistrictController@create');
Route::post('/admin/district/create', 'DistrictController@add');
Route::get('/admin/district/{mahuyen}/edit', 'DistrictController@edit');
Route::post('/admin/district/update', 'DistrictController@update');
Route::get('/admin/district/{mahuyen}/delete', 'DistrictController@destroy');


// Các route của Commune
Route::get('/admin/{mahuyen}/commune', 'CommuneController@index')->name('commune');
Route::get('/admin/commune/create', 'CommuneController@create');
Route::post('/admin/commune/create', 'CommuneController@add');
Route::get('/admin/commune/{maxa}/edit', 'CommuneController@edit');
Route::post('/admin/commune/update', 'CommuneController@update');
Route::get('/admin/commune/{mxa}/delete', 'CommuneController@destroy');
Route::get('/admin/commune', 'CommuneController@list');

// Route của QLSL
Route::get('/location', 'QuanLySatLoController@location' )->name('location');
Route::get('/admin/qlsl/addlocation', 'QuanLySatLoController@shape');
Route::get('/admin/qlsl/addlocation/{mahuyen}', 'QuanLySatLoController@getxa');
Route::post('/admin/qlsl/addlocation', 'QuanLySatLoController@insertlocation');
Route::get('/admin/qlsl/{madiadiem}/editlocation', 'QuanLySatLoController@editLocation');
Route::post('/admin/qlsl/updatelocation', 'QuanLySatLoController@updateLocation');
Route::get('/admin/qlsl/{madiadiem}/delete', 'QuanLySatLoController@destroy');


Route::get('/admin/map', 'MapController@map')->name('map');
Route::get('/admin/map', 'MapController@loadPolyline');





