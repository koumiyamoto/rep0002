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

Route::get('about', 'PagesController@about')->name('about');
Route::get('contact', 'PagesController@contact')->name('contact');
Route::post('contact/mail', 'PagesController@mail')->name('mail');

Route::get('/', 'FirstController@index')->name('home');
Route::get('/posts/orderNew', 'FirstController@orderNew')->name('orderNew');
Route::get('/posts/orderOld', 'FirstController@orderOld')->name('orderOld');
Route::get('/posts/orderPopular', 'FirstController@orderPopular')->name('orderPopular');
Route::get('/posts/manageOrderNew', 'ManagerController@manageOrderNew')->name('manageOrderNew');
Route::get('/posts/manageOrderOld', 'ManagerController@manageOrderOld')->name('manageOrderOld');
Route::get('/posts/manageOrderPopular', 'ManagerController@manageOrderPopular')->name('manageOrderPopular');
Route::post('/posts/tag', 'FirstController@tag')->name('tag');
Route::post('/posts/search', 'FirstController@search')->name('search');
// Route::get('posts/release', 'FirstController@release')->name('release');
Route::get('dashboard', 'DashboardController@index')->name('dashboard');
Route::get('/posts/{post}', 'FirstController@show')->name('show')->where('post', '[0-9]+');
Route::get('/posts/new', 'FirstController@new')->name('new');
Route::post('/posts', 'FirstController@create');
Route::get('/posts/{post}/edit', 'FirstController@edit')->name('edit');
Route::patch('/posts/{post}', 'FirstController@update');
Route::delete('/posts/{post}', 'FirstController@destroy');
Route::post('/comments/{post}', 'CommentsController@comment');
Route::delete('/posts/{post}/comments/{comment}', 'CommentsController@destroy');

Auth::routes();

Route::get('other', 'OtherController@index')->name('other');

Route::get('manager', 'ManagerController@manager')->name('manager');
Route::post('/manager/search', 'ManagerController@search')->name('managerSearch');
Route::get('/manager/{post}', 'ManagerController@show')->name('managerShow')->where('post', '[0-9]+');






// Route::get('/home', 'HomeController@index')->name('home');
