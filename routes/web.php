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
Route::group(['middleware' => ['web', 'login']], function () {
    Route::get('/',                      'Home\HomeController@index');

    Route::get('/template',              'Home\HomeController@template');

    Route::get('/template/edit',         'Home\HomeController@edit');

    Route::get('/template/create',       'Home\HomeController@create');

    Route::get('/development',           'Home\HomeController@development');

    Route::get('/template/assign-order', 'Home\HomeController@assignOrder');

    Route::get('/article',               'Article\ArticleController@article');

    Route::get('/login',                 'Home\HomeController@login');

    Route::post('/register',             'User\UserController@register');

    Route::post('/login',                'User\UserController@login');

    Route::get('/logout',                'User\UserController@logout');

    Route::get('/about',                 'User\UserController@about');

    Route::get('/about/{id}',            'User\UserController@aboutShow');

    Route::get('/time-line',             'User\UserController@timeLine');

    Route::post('/upload',               'Upload\UploadController@upload');

    Route::prefix('tool')->group(function () {
        Route::get('/time',              'Tool\TimeToolController@index');
        Route::get('/crypt',             'Tool\TimeToolController@crypt');
    });

    Route::prefix('book')->group(function () {
        Route::get('/',                  'Article\ArticleController@index');
        Route::get('/add-note',          'Article\ArticleController@addNote');
        Route::get('/show/{id}',         'Article\ArticleController@show');
        Route::post('/add',              'Article\ArticleController@add');
        Route::get('/delete/{id}',       'Article\ArticleController@delete');
    });

    Route::prefix('process')->group(function () {
        Route::get('/',                  'Process\ProcessController@index');
        Route::get('/all',               'Process\ProcessController@all');
        Route::get('/delete/{id}',       'Process\ProcessController@delete');
        Route::get('/complete/{id}',     'Process\ProcessController@complete');
        Route::get('/cancel/{id}',       'Process\ProcessController@cancel');
        Route::post('/add',              'Process\ProcessController@add');
        Route::get('/main',              'Process\ProcessController@mainProcess');
        Route::get('/change-status',     'Process\ProcessController@changeStatus');
    });
});

