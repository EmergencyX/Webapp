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


Route::group(['prefix' => 'api', 'middleware' => ['api']], function () {
    Route::get('mods/recent', 'Api\ProjectController@recent');
    // Route::post('auth/login', 'Auth\AuthController@postLogin');

    Route::get('projects/{project}/images', 'Api\ImageController@index');
    Route::post('projects/{project}/images', 'Api\ImageController@store');

    Route::group([/*'middleware' => 'auth:api'*/], function () {
        Route::get('projects/{project}', 'Api\ProjectController@show');
        Route::get('users/{user}', 'Api\ProjectController@show');

        Route::get('project/{project}/release', 'Api\ReleaseController@index');
        Route::post('project/{project}/release', 'Api\ReleaseController@store');
        Route::delete('release/{release}', 'Api\ReleaseController@remove');
    });

});

Route::group(['middleware' => ['web']], function () {
    //UPGRADED
    Route::get('/', 'HomeController@index');

    Route::get('mods', 'Project\ProjectController@index');
    Route::get('mods/{project}', 'Project\ProjectController@show')->where('project', '[0-9]+');
    Route::get('mods/{project}-{seo}', 'Project\ProjectController@show')->where(['project' => '[0-9]+', 'seo' => '.*']);

    Route::get('mods/{project}/bilder-hochladen', 'Project\ImageController@create');
    Route::post('mods/{project}/bilder-hochladen', 'Project\ImageController@store');


    //END UPGRADED

    Route::get('/download', 'HomeController@download');

    // Authentication routes...
    Route::get('auth/login', 'Auth\LoginController@showLoginForm');
    Route::post('auth/login', 'Auth\LoginController@login');
    Route::post('auth/logout', 'Auth\LoginController@logout');


    Route::get('users', 'UserController@index');
    Route::get('users/{id}', 'UserController@show')->where('id', '[0-9]+');
    Route::get('users/{id}-{seo}', 'UserController@show')->where(['id' => '[0-9]+', 'seo' => '.*']);

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

        Route::get('mods/{id}/create-release', 'ReleaseController@create');

        Route::get('mods/{project}/repositories', 'ProjectRepositoryController@index'); //Todo: Seo hier?
        Route::get('mods/{project}/repositories/{repository}', 'ProjectRepositoryController@show')->where('repository',
            '[0-9]+');
        Route::get('mods/{project}/repositories/create', 'ProjectRepositoryController@create');

        Route::post('mods/{project}/repositories', 'ProjectRepositoryController@store');

        Route::get('mods/{project}/toggle-follow', 'ProjectController@toggleFollow');

        Route::post('mods/{project}/repositories/{repository}/release', 'ReleaseController@store');
        Route::get('mods/{id}/releases', 'ReleaseController@index');
        Route::get('mods/{id}/releases/{release_id}', 'ReleaseController@show');
        Route::get('mods/{project}/releases/{release}/destroy', 'ReleaseController@destroy');


        Route::get('mods/{project}/install', 'ReleaseInstallationController@index');


        Route::get('mods/{project}/links/edit', 'LinkController@edit');
        Route::get('mods/{project}/links/{link}/delete', 'LinkController@delete');
        Route::patch('mods/{project}/links', 'LinkController@update');
        Route::post('mods/{project}/links', 'LinkController@store');


        Route::get('release/{release}/post-install', 'ReleaseInstallationController@postInstall');
        Route::get('release/{release}/post-uninstall', 'ReleaseInstallationController@postUninstall');
        Route::get('release/{release}/post-cancel', 'ReleaseInstallationController@postCancel');
        Route::get('release/{release}/post-play', 'ReleaseInstallationController@postPlay');

        Route::get('multiplayer', 'AppointmentController@index');
        Route::get('multiplayer/create', 'AppointmentController@create');
        Route::get('multiplayer/{appointment}', 'AppointmentController@show');
        Route::post('multiplayer', 'AppointmentController@store');
        Route::get('multiplayer/{appointment}/edit', 'AppointmentController@edit');
        Route::patch('multiplayer/{appointment}', 'AppointmentController@update');
        Route::delete('multiplayer/{appointment}', 'AppointmentController@remove');

        Route::post('multiplayer/{appointment}/join', 'AppointmentController@join');
    });
});