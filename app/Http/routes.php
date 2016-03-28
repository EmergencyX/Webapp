<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    Route::get('/', 'HomeController@index');

    // Authentication routes...
    Route::get('auth/login', 'Auth\AuthController@getLogin');
    Route::post('auth/login', 'Auth\AuthController@postLogin');
    Route::get('auth/logout', 'Auth\AuthController@logout');
    
    Route::get('mods', 'ProjectController@index');
    Route::get('mods/{id}', 'ProjectController@show')->where('id', '[0-9]+');
    Route::get('mods/{id}-{seo}', 'ProjectController@show');
    
    Route::get('users', 'UserController@index');
    Route::get('users/{id}', 'UserController@show')->where('id', '[0-9]+');
    Route::get('users/{id}-{seo}', 'UserController@show');
  
    Route::group(['middleware' => ['auth']], function () {
        Route::get('notifications', 'NotificationController@index');
        Route::post('invitation/update', 'InvitationController@update');
    
        Route::delete('invitation/reset', 'InvitationController@resetRejected');
        
        Route::get('mods/create', 'ProjectController@create');
        Route::post('mods', 'ProjectController@store');
        Route::get('mods/{id}/edit', 'ProjectController@edit');
        Route::patch('mods/{id}', 'ProjectController@update');
        
        Route::get('mods/{id}/create-media', 'ProjectController@createMedia');
        Route::post('mods/{id}/store-media', 'ProjectController@storeMedia');
    });
});