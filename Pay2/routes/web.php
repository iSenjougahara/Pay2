<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
   // $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
    $router->post('/register', 'UserController@create');
    $router->put('/userUpdate/{id}', 'UserController@update');
    $router->post('/user', 'UserController@store');
    $router->post('/logout', 'AuthController@logout');
    $router->delete('/userDelete/{id}', 'UserController@delete');
    $router->get('/user/{id}', 'UserController@getById');
    $router->get('/users', 'UserController@getAll');
    $router->post('/depo', 'ContaController@deposito');
    $router->post('/trans', 'ContaController@transferencia');
    

    $router->group(['middleware' => 'auth'], function () use ($router) {
       
        
        
        //$router->get('/posts', 'PostController@index');
        //$router->post('/posts', 'PostController@store');
        //$router->put('/posts/{id}', 'PostController@update');
        //
    });
});