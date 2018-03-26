<?php

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

Route::group(['prefix' => 'hooks'], function () {
    Route::get('tus', 'TusController@hook');
    Route::post('tus', 'TusController@hook');
});


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

