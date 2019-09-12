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
    return view('welcome');
});

Route::group(['prefix' => 'admin'], function() {
    Auth::routes(['register' => false]);

    Route::group(['middleware' => ['auth'], 'as' => 'admin.'], function() {
        Route::get('/', 'Admin\HomeController@index')->name('home');

        Route::resource('articles', 'Admin\ArticleController');
        Route::resource('categories', 'Admin\CategoryController')->except(['show']);
    });
});
