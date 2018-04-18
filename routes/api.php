<?php

use Illuminate\Http\Request;

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

Route::apiResource('containers', 'ContainerController');
Route::get('/containers/{id}/export', 'ContainerController@export');
Route::post('/containers/{id}/stop', 'ContainerController@stop');
Route::post('/containers/{id}/start', 'ContainerController@start');
Route::post('/containers/{id}/restart', 'ContainerController@restart');
Route::post('/containers/{id}/kill', 'ContainerController@kill');
Route::post('/containers/{id}/pause', 'ContainerController@pause');
Route::post('/containers/{id}/unpause', 'ContainerController@unpause');
Route::delete('/containers/{id}/remove', 'ContainerController@remove');
Route::get('/containers/{id}/top', 'ContainerController@top');
Route::get('/containers/{id}/logs', 'ContainerController@logs');
Route::apiResource('hosts', 'HostController');
Route::apiResource('images', 'ImageController');
Route::apiResource('logs', 'LogController');
