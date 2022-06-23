<?php

use Illuminate\Support\Facades\Route;

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

/*Route::get('/', function () {
    //return view('auth/login');
    //return view('/seluruhBarang');
    return redirect()->route('/seluruhBarang');
});*/ 

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('categories', 'CategoriesController')->middleware('auth');

Route::resource('medicines', 'MedicinesController')->middleware('auth');
Route::get('/', 'MedicinesController@front_index');//check barang ae maen pengecekan auth di button invisible/!
Route::get('add-to-cart/{id}','MedicinesController@addToCart');
Route::get('min-to-cart/{id}','MedicinesController@minToCart');
Route::get('checkout','MedicinesController@checkout')->middleware('auth');


Route::get('medicinesTerlaris','MedicinesController@medicinesTerlaris')->middleware('auth');
Route::get('userTerbanyakBeli','TransactionController@userTerbanyakBeli')->middleware('auth');

Route::resource('users', 'UserController')->middleware('auth');
Route::resource('stokAwal', 'StokAwalController')->middleware('auth');
Route::resource('adjustmentStok', 'AdjustmentStokController')->middleware('auth');
Route::resource('transaction', 'TransactionController')->middleware('auth');

//index 


