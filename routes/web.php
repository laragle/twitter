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

Route::get('/', 'HomeController@index');

Auth::routes();

Route::group(['prefix' => 'account', 'namespace' => 'Account', 'as' => 'account.'], function () {
    Route::group(['prefix' => 'verify', 'namespace' => 'Verification', 'as' => 'verify.'], function () {
        Route::get('email/{token}', 'EmailController@verify')->name('email');
    });
});

Route::group(['prefix' => '{username}', 'namespace' => 'User'], function () {
    Route::resource('tweet', 'TweetController');
});
