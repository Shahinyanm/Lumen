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
    $router->get('users',  ['uses' => 'UserController@showAllAuthors']);
    $router->get('users/{id}', ['uses' => 'UserController@show']);
    $router->post('users', ['uses' => 'UserController@create']);
    $router->delete('users/{id}', ['uses' => 'UserController@delete']);
    $router->put('users/{id}', ['uses' => 'UserController@update']);

    $router->get('teams',  ['uses' => 'TeamController@showAllAuthors']);
    $router->get('teams/{id}', ['uses' => 'TeamController@show']);
    $router->post('teams', ['uses' => 'TeamController@create']);
    $router->delete('teams/{id}', ['uses' => 'TeamController@delete']);
    $router->put('teams/{id}', ['uses' => 'TeamController@update']);




});