<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::post('/login', 'AuthController@login');


Route::middleware('auth:sanctum')->group(function () {

    //course routes
    Route::get('/courses', 'CourseController@index');
    Route::get('/courses/{id}', 'CourseController@show');
});
