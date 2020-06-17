<?php

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

Route::group(['middleware' => ['web', 'login']], function () {
    Route::prefix('category')->group(function () {
        Route::get('/main',              'Category\CategoryController@main');
        Route::get('/child/{id}',        'Category\CategoryController@child');
        Route::post('/save',             'Category\CategoryController@save');
        Route::get('/child/all',         'Category\CategoryController@all');
    });
    Route::prefix('article')->group(function () {
        Route::get('/collect',           'Article\ArticleController@collect');
    });
    Route::resource('/books',            'Book\BookController');
});
