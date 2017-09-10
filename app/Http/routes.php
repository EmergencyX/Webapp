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

Route::group(['prefix' => 'api', 'middleware' => ['bindings']], function () {
    Route::get('mods/recent', 'Api\ProjectController@recent');
    // Route::post('auth/login', 'Auth\AuthController@postLogin');

    Route::get('users/{user}', 'Api\ProjectController@show');
    Route::get('projects/{project}', 'Api\ProjectController@show');

    Route::get('projects/{project}/releases', 'Api\ReleaseController@index');
    Route::get('projects/{project}/releases/{release}', 'Api\ReleaseController@show');

    Route::get('projects/{project}/images', 'Api\ImageController@index');
    Route::get('projects/{project}/images/{image}', 'Api\ImageController@show');

    Route::get('releases/download', 'Api\ReleaseController@download');


    Route::group(['middleware' => 'auth:api'], function () {
        //Route::get('projects/create', 'Api\ProjectController@create'); //Todo
        //Route::post('projects', 'Api\ProjectController@store'); //Todo
        //Route::patch('projects/{project}', 'Api\ProjectController@update'); //Todo
        //Route::delete('projects/{project}', 'Api\ProjectController@delete'); //Todo

        Route::post('projects/{project}/images/{image}', 'Api\ImageController@store');
        Route::post('projects/{project}/images', 'Api\ImageController@store');
        Route::delete('projects/{project}/images/{image}', 'Api\ImageController@remove');


        Route::post('projects/{project}/releases', 'Api\ReleaseController@store');

        Route::delete('projects/{project}/releases/{release}', 'Api\ReleaseController@remove');
    });
});


Route::group(['middleware' => ['web']], function () {
    //UPGRADED
    Route::get('/', 'HomeController@index');
    Route::get('kontakt', 'HomeController@contact');

    Route::get('multiplayer/browser/{gameSlug}', 'Multiplayer\MultiplayerController@index');

    Route::get('mods', 'Project\ProjectController@index');
    Route::get('mods/{project}', 'Project\ProjectController@show')->where('project', '[0-9]+');
    Route::get('mods/{project}-{seo}', 'Project\ProjectController@show')->where(['project' => '[0-9]+', 'seo' => '.*']);

    Route::get('mods/create', 'Project\ProjectController@create'); //Todo
    Route::post('mods', 'Project\ProjectController@store'); //Todo
    Route::patch('mods/{project}', 'Project\ProjectController@update'); //Todo
    Route::delete('mods/{project}', 'Project\ProjectController@delete'); //Todo

    Route::get('mods/{project}/images', 'Project\ImageController@index');
    //Route::get('mods/{project}/images/{image}', 'Project\ImageController@show');

    Route::get('users/{user}', 'User\UserController@show')->where('user', '[0-9]+');
    Route::get('users/{user}-{seo}', 'User\UserController@show')->where(['user' => '[0-9]+', 'seo' => '.*']);
    Route::get('users/{user}/edit', 'User\UserController@edit');
    Route::patch('users/{user}', 'User\UserController@update');


    Route::group(['middleware' => 'auth'], function () {
        Route::get('mods/{project}/images/create', 'Project\ImageController@create');
        Route::post('mods/{project}/images', 'Project\ImageController@store');
        Route::get('mods/{project}/toggle-follow', 'Project\ProjectController@toggleFollow');
        Route::get('mods/{project}/edit', 'Project\ProjectController@edit');

        Route::get('mods/{project}/release/create', 'Project\ReleaseController@create');
        Route::post('mods/{project}/releases', 'Project\ReleaseController@store');
        Route::get('mods/{project}/releases/{release}', 'Project\ReleaseController@show');
        Route::get('mods/{project}/releases', 'Project\ReleaseController@index');
        Route::get('mods/{project}/releases/{release}/remove', 'Project\ReleaseController@remove');
        Route::get('mods/{project}/releases/{toRelease}/download', 'Project\ReleaseController@download');

        Route::get('mods/updatecheck', 'Project\ReleaseController@updateCheck');

        Route::post('mods/{project}/images/{image}/remove', 'Project\ImageController@remove');
    });
    //END UPGRADED

    //Route::get('/download', 'HomeController@download');

    // Authentication routes...
    Route::get('auth/login', 'Auth\LoginController@showLoginForm');
    Route::post('auth/login', 'Auth\LoginController@login');
    Route::get('auth/logout', 'Auth\LoginController@logout');
    Route::post('auth/logout', 'Auth\LoginController@logout');

    if (! env('DEMO', true)) {
        Route::get('auth/register', 'Auth\RegisterController@createForm');
        Route::post('auth/register', 'Auth\RegisterController@register');
    }

    /*
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
    */
});

