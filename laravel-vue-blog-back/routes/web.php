<?php

use App\Http\Middleware\AdminCheck;
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





Route::prefix('app')->middleware([AdminCheck::class])->group(function(){

//tag
Route::post('/create_tag','AdminController@addTag');
Route::get('/get_tags','AdminController@getTag');
Route::post('/edit_tag','AdminController@editTag');
Route::post('/delete_tag','AdminController@deleteTag');

//category
Route::post('/upload','AdminController@upload');
Route::post('/delete_image','AdminController@deleteImage');
Route::post('/create_category','AdminController@addCategory');
Route::get('/get_categories','AdminController@getCategory');
Route::post('/edit_category','AdminController@editCategory');
Route::post('/delete_category','AdminController@deleteCategory');

//user
Route::post('/create_user','AdminController@createUser');
Route::get('/get_users','AdminController@getUsers');
Route::post('/edit_users','AdminController@editUser');
Route::post('/admin_login','AdminController@adminLogin');

//role
Route::post('/create_role','AdminController@createRole');
Route::get('/get_roles','AdminController@getRole');
Route::post('/edit_role','AdminController@editRole');
Route::post('/edit_role','AdminController@editRole');
Route::post('/delete_role','AdminController@deleteRole');

//Assign Role
Route::post('/assign_roles','AdminController@AssignRole');

//blog
Route::post('/create_blog','AdminController@createBlog');//create a new blog
Route::get('/blogs_data','AdminController@blogdata'); //get the blogs item
Route::post('/delete_blog','AdminController@deleteBlog'); //delete the blogs item
Route::get('/blog_single/{id}','AdminController@singleBlogItem'); //edit the blogs item
Route::post('/update_blog/{id}','AdminController@updateBlog');//update

});
Route::post('createBlog','AdminController@uploadEditorImage');

Route::get('/slug','AdminController@slug');




Route::any('{slug}','AdminController@index')->where('slug','([A-z\-/\_.]+?)');

Route::get('/logout','AdminController@logout');
Route::get('/','AdminController@index');
