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
//
$router->get('/', function () use ($router) {
	return $router->app->version();
});

$router->post('api/login', ['uses' => 'AuthController@login']);
$router->post('api/register', ['uses' => 'AuthController@register']);

$router->group(['prefix' => 'api', 'middleware' => 'jwt'], function () use ($router) {
	$router->get('me', ['uses' => 'AuthController@me']);

	$router->post('logout', ['uses' => 'AuthController@logout']);

	//users Routes
	$router->get('users', ['uses' => 'UserController@showAllUsers']);
	$router->get('users/{id}', ['uses' => 'UserController@show']);
	$router->delete('users/{id}', ['uses' => 'UserController@delete']);
	$router->put('users/{id}', ['uses' => 'UserController@update']);

	//Team routes
	$router->get('teams', ['uses' => 'TeamController@showAllTeams']);
	$router->get('myTeams', ['uses' => 'TeamController@showAllMyTeams']);
	$router->get('teams/{id}', ['uses' => 'TeamController@show']);
	$router->post('teams', ['uses' => 'TeamController@create']);
	$router->delete('teams/{id}', ['uses' => 'TeamController@delete']);
	$router->put('teams/{id}', ['uses' => 'TeamController@update']);

	//Role Routes
	$router->get('roles', ['uses' => 'RoleController@showAllRoles']);
	$router->get('roles/{id}', ['uses' => 'RoleController@show']);
	$router->post('roles', ['uses' => 'RoleController@create']);
	$router->delete('roles/{id}', ['uses' => 'RoleController@delete']);
	$router->put('roles/{id}', ['uses' => 'RoleController@update']);

	//actions routes
	$router->post('assignTeam', ['uses' => 'ActionController@assignTeam']);
	$router->post('assignRole', ['uses' => 'ActionController@assignRole']);

	$router->post('unAssignTeam', ['uses' => 'ActionController@unAssignTeam']);
	$router->post('unAssignRole', ['uses' => 'ActionController@unAssignRole']);
	$router->post('setOwner', ['uses' => 'ActionController@setOwner']);
});

$router->get('/', function () use ($router) {
	return view('app');
});

$router->get('/{any:.*}', 'MainController@index');
