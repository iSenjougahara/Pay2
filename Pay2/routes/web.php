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


$router->get('/', function () {
    return view('login');
});
$router->get('/logged', function () {
    return view('logged');
});
$router->get('/users', function () {
    return view('users');
});


$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/login', 'UserController@login');
    $router->post('/register', 'UserController@create');
    $router->put('/userUpdate/{id}', 'UserController@update');
 
    $router->post('/logout', 'UserController@logout');
   
    $router->get('/user/{id}', 'UserController@getById');
    $router->delete('/userDelete/{id}', 'UserController@delete');
   
   
  

    $router->group(['middleware' => 'auth'], function () use ($router) {
        // Add authenticated routes here
        $router->get('/users', 'UserController@getAll');
        $router->get('/user', 'UserController@getSelf');
        $router->get('/conta', 'UserController@getConta');
        $router->get('/movimentos', 'ContaController@getMovimentos');
        $router->post('/depo', 'ContaController@deposito');
        $router->post('/trans', 'ContaController@transferencia');
        


    });
});
