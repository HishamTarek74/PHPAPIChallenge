<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//all routes / api here must be api authenticated
Route::group(['prefix' => 'v1','middleware' => ['api'], 'namespace' => 'Api\V1'], function () {

    Route::post('login', 'UserAuthController@login');
    Route::post('logout', 'UserAuthController@logout');
    Route::post('refresh', 'UserAuthController@refresh');
    Route::post('register', 'UserRegistrationController@register');
    Route::apiResource('post', 'PostController')->except(['index']);

    Route::get('userposts/{id}', 'PostController@index');
    Route::resource('user', 'UserController')->only(['show' , 'update']);

    //Admin Login Route
    Route::group(['prefix' => 'admin','namespace'=>'Admin'],function (){
        Route::post('login', 'AuthController@login');

    });

});
 
Route::apiResource('posts', 'Api\V1\Admin\PostController');
Route::apiResource('users', 'Api\V1\Admin\UsersController'); 

//Admin Routes Instaed Of checkAdminToken:admin-api
Route::group(['prefix' => 'v1/admin','middleware' => ['api','checkAdminToken:admin-api'], 'namespace' => 'Api\V1\Admin'], function () {
    // Route::apiResource('posts', 'PostController');
    // Route::apiResource('users', 'UsersController'); 

});
