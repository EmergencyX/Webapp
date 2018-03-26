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




Route::post('projects/{project}/release', 'Project\ReleaseController@store');

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

/*
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
*/
// Authentication routes...
Route::get('auth/login', 'Auth\LoginController@showLoginForm');
Route::post('auth/login', 'Auth\LoginController@login');
Route::get('auth/logout', 'Auth\LoginController@logout');
Route::post('auth/logout', 'Auth\LoginController@logout');
