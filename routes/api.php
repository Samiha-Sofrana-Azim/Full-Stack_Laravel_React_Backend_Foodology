<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

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

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'UserController@register');
    Route::post('login', 'UserController@login')->name('login');
    Route::post('forgot-password', 'UserController@forgotPassword');

    Route::get('postlist', 'PostController@postlist');
});

Route::post('addpost', 'PostController@addPost');
Route::get('post/{id}', 'PostController@getPost');
Route::post('updatepost/{id}', 'PostController@updatePost');
Route::get('/post/delete/{id}', 'PostController@delete');

Route::post('addcomment', 'PostController@addComment');


Route::post('logout', 'UserController@logout');
Route::get('user', 'UserController@authenticatedUser');
Route::group(['middleware' => 'auth:users'], function () {
    Route::prefix('user')->group(function () {

        Route::get('user', 'UserController@authenticatedUser');
    });
});
