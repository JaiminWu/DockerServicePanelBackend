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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/logs', function() {
    $client = new GuzzleHttp\Client();
    $res = $client->request('GET', 'http://203.195.156.188:2375/containers/dockertensorflowplayground_nginx_1/logs?stderr=true&since=0&until='.time());
    echo $res->getBody();
});

Route::get('/containers', function() {
    $client = new GuzzleHttp\Client();
    $res = $client->request('GET', 'http://203.195.156.188:2375/containers/json?all=1');
    echo $res->getBody();
});

Route::get('/container', function() {
    $client = new GuzzleHttp\Client();
    $res = $client->request('GET', 'http://203.195.156.188:2375/containers/21c0c45d40e60f17e791473e5c41c34f509cfedf5268aa06ac450be79158b769/json');
    echo $res->getBody();
});

Route::get('/images', function() {
    $client = new GuzzleHttp\Client();
    $res = $client->request('GET', 'http://203.195.156.188:2375/images/json');
    echo $res->getBody();
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
