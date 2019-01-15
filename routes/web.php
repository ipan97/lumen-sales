<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
 */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->group(['prefix' => 'customers'], function () use ($router) {
        $router->get('/', 'CustomerController@index');
        $router->post('/', 'CustomerController@store');
        $router->get('/{id}', 'CustomerController@show');
        $router->put('/{id}', 'CustomerController@update');
        $router->patch('/{id}', 'CustomerController@update');
        $router->delete('/{id}', 'CustomerController@destroy');
    });
    $router->group(['prefix' => 'products'], function () use ($router) {
        $router->get('/', 'ProductController@index');
        $router->post('/', 'ProductController@store');
        $router->get('/{id}', 'ProductController@show');
        $router->put('/{id}', 'ProductController@update');
        $router->patch('/{id}', 'ProductController@update');
        $router->delete('/{id}', 'ProductController@destroy');
    });
    $router->group(['prefix' => 'admins'], function () use ($router) {
        $router->get('/', 'AdminController@index');
        $router->post('/', 'AdminController@store');
        $router->get('/{id}', 'AdminController@show');
        $router->put('/{id}', 'AdminController@update');
        $router->patch('/{id}', 'AdminController@update');
        $router->delete('/{id}', 'AdminController@destroy');
    });
    $router->group(['prefix' => 'bills'], function () use ($router) {
        $router->get('/', 'BillController@index');
        $router->post('/', 'BillController@store');
        $router->get('/{id}', 'BillController@show');
        $router->put('/{id}', 'BillController@update');
        $router->patch('/{id}', 'BillController@update');
        $router->delete('/{id}', 'BillController@destroy');
    });
});
