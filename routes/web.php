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

//pages
Route::get('about', 'PagesController@about')
  ->name('about');

Route::get('contact', 'PagesController@contact')
  ->name('contact');

Route::post('contact/mail', 'PagesController@mail')
  ->name('mail');

Route::get('dashboard', 'DashboardController@index')
->name('dashboard');

Route::get('other', 'OtherController@index')
  ->name('other');


//index
Route::get('/', 'FirstController@index')
  ->name('home');

//posts
Route::get('/posts/orderNew', 'FirstController@orderNew')
  ->name('orderNew');

Route::get('/posts/orderOld', 'FirstController@orderOld')
  ->name('orderOld');

Route::get('/posts/orderPopular', 'FirstController@orderPopular')
  ->name('orderPopular');

Route::post('/posts/tag', 'FirstController@tag')
  ->name('tag');

Route::get('/posts/search', 'FirstController@search')
  ->name('search');

Route::get('/posts/{post}', 'FirstController@show')
  ->name('show')
  ->where('post', '[0-9]+');

Route::get('/posts/new', 'FirstController@new')
  ->name('new');

Route::post('/posts', 'FirstController@create');

Route::get('/posts/{post}/edit', 'FirstController@edit')
  ->name('edit')
  ->where('post', '[0-9]+');

Route::patch('/posts/{post}', 'FirstController@update')
  ->name('update');

Route::delete('/posts/{post}/destroy', 'FirstController@destroy')
  ->name('destroy');

//comments
Route::post('/comments/{post}', 'CommentsController@comment');

Route::delete('/posts/{post}/comments/{comment}', 'CommentsController@destroy');

Route::get('/posts/{post}/publish', 'FirstController@publish')
  ->name('publish');

//Auth
Auth::routes();

Route::get('manager', 'ManagerController@manager')
  ->name('manager');

Route::get('/manager/search', 'ManagerController@search')
  ->name('managerSearch');

Route::get('/manager/{post}', 'ManagerController@show')
  ->name('managerShow')->where('post', '[0-9]+');

Route::get('/posts/manageOrderNew', 'ManagerController@manageOrderNew')
  ->name('manageOrderNew');

Route::get('/posts/manageOrderOld', 'ManagerController@manageOrderOld')
  ->name('manageOrderOld');

Route::get('/posts/manageOrderPopular', 'ManagerController@manageOrderPopular')
  ->name('manageOrderPopular');

