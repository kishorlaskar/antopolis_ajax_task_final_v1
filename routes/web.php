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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//category route starts here

Route::resource('categories','CategoryController');

//category route ends here

//Brand Route Starts here


    Route::get('/brand/index','BrandController@index')->name('brand.index');
    Route::get('/brand/get','BrandController@get')->name('brand.get');
    Route::post('/brand/store','BrandController@store')->name('brand.store');
    Route::get('/brand/edit','BrandController@edit')->name('brand.edit');
    Route::post('/brand/update','BrandController@update')->name('brand.update');
    Route::post('/brand/destroy','BrandController@destroy')->name('brand.destroy');


//Brand Route ends here

//Subcategory route starts here.

Route::resource('subcategory','SubcategoryController');

//Subcategory route ends here..

//Products Controller Starts here....


Route::get('/product/index','ProductController@index')->name('product.index');
Route::get('/product/brand/get','ProductController@get')->name('product.get');
Route::post('/product/brand/store','ProductController@store')->name('product.store');
Route::get('/product/brand/edit','ProductController@edit')->name('product.edit');
Route::post('/product/brand/update','ProductController@update')->name('product.update');
Route::post('/product/brand/destroy','ProductController@destroy')->name('product.destroy');

//Products Route ends here...
