<?php

declare(strict_types = 1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('articles', 'API\ArticleController@index')
    ->name('article.list');
Route::post('article', 'API\ArticleController@store')
    ->name('article.create');
Route::get('article/{slug}', 'API\ArticleController@show')
    ->name('article.show');

Route::get('categories', 'API\CategoryController@index')
    ->name('category.list');
Route::get('category/{slug}', 'API\CategoryController@show')
    ->name('category.show');