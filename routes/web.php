<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return response(['Blog App is running'], 200);
});



Route::get('/verify/{token}/{email}', 'UserController@verified');
Route::get('/forgot/{token}/{email}', 'UserController@forgotPasswordForm');
Route::post('/update-forgot-password', 'UserController@forgotPasswordUpdate')->name('forgot.update');
