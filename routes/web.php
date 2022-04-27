<?php

use App\Http\Controllers\TestController;
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
// Main Category API endpoints
Route::get('/app/get_categories', 'AdminController@getCategory')->middleware('cors');
Route::post('/app/create_category', 'AdminController@addCategory');
Route::post('/app/edit_category', 'AdminController@editCategory');
Route::post('/app/delete_category', 'AdminController@deleteCategory');

// SubCategory API endpoints
// Route::post('/SubCategories/get_sub_categories', 'AdminController@getSubCategory')->middleware('cors');
Route::get('/SubCategories/get_sub_categories/{id}', 'AdminController@getSubCategory')->middleware('cors');
Route::post('/SubCategories/create_sub_category', 'AdminController@addSubCategory');
Route::post('/SubCategories/edit_sub_category', 'AdminController@editSubCategory');
Route::post('/SubCategories/delete_sub_category', 'AdminController@deleteSubCategory');
Route::post('/SubCategories/delete_sub_category_single', 'AdminController@deleteSubCategorySingle');

// Item API endpoints
Route::get('/items/get_items/{id}', 'AdminController@getItem')->middleware('cors');
Route::post('/items/create_item', 'AdminController@addItem');
Route::post('/items/edit_item', 'AdminController@editItem');
Route::post('/items/delete_item', 'AdminController@deleteItem');
Route::post('/items/delete_item_category', 'AdminController@deleteItemCategory');

// Get All Contents
Route::get("/app/get_all_contents" , 'AdminController@getAllContents')->middleware('cors');

Route::get('/', function(){
    return view('welcome');
});

Route::get('/testpage', function(){
    return view('welcome');
});

Route::get('/new', 'TestController@controllerMethod');

Route::any('/{slug}', function(){
    return view('welcome');
});
