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
    Route::get('mods/{id}-{seo}', 'ProjectController@show')->where(['id'=>'[0-9]+','seo'=>'.*']);

    Route::get('users', 'UserController@index');
    Route::get('users/{id}', 'UserController@show')->where('id', '[0-9]+');
    Route::get('users/{id}-{seo}', 'UserController@show')->where(['id'=>'[0-9]+','seo'=>'.*']);

    Route::group(['middleware' => ['auth']], function () {
        Route::get('notifications', 'NotificationController@index');
        Route::post('invitation/update', 'InvitationController@update');

        Route::delete('invitation/reset', 'InvitationController@resetRejected');

        Route::get('mods/create', 'ProjectController@create');
        Route::post('mods', 'ProjectController@store');
        Route::get('mods/{id}/edit', 'ProjectController@edit');
        Route::patch('mods/{id}', 'ProjectController@update');

        Route::get('mods/{id}/delete', 'ProjectController@delete');

        Route::get('mods/{id}/create-media', 'ProjectController@createMedia');
        Route::post('mods/{id}/store-media', 'ProjectController@storeMedia');

        Route::get('users/{id}/edit', 'UserController@edit');
        Route::patch('users/{id}', 'UserController@update');


        Route::get('media/{id}/delete', 'MediaController@delete');
        
        Route::get('mods/{id}/repositories/{project_repository_id}/release/create', 'ReleaseController@create');

        Route::get('mods/{project}/repositories', 'ProjectRepositoryController@index'); //Todo: Seo hier?
        Route::get('mods/{project}/repositories/{repository}', 'ProjectRepositoryController@show')->where('repository', '[0-9]+');
        Route::get('mods/{project}/repositories/create', 'ProjectRepositoryController@create');

        Route::post('mods/{project}/repositories', 'ProjectRepositoryController@store');

        Route::post('mods/{project}/repositories/{repository}/release', 'ReleaseController@store');
        Route::get('mods/{id}/releases', 'ReleaseController@index');
        Route::get('mods/{id}/releases/{release_id}', 'ReleaseController@show');


    });
});