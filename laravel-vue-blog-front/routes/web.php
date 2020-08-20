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




// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');


Route::get('/','BlogController@index');
Route::get('/blog/{slug}','BlogController@singleBlog');
Route::get('/category/{categoryName}/{id}','BlogController@categoryIndex');
Route::get('/tag/{tagName}/{id}','BlogController@tagIndex');
Route::get('/blogs','BlogController@AllBlogs');
Route::get('/search','BlogController@search');

