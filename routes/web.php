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

// Post
$router->get('/posts', 'PostsController@index');

$router->get('/posts', 'PostsController@index');
$router->post('/posts', 'PostsController@store');

// Post
$router->get('/posts', 'PostsController@index');
$router->post('/posts', 'PostsController@store');
$router->get('/post/{id}', 'PostsController@show');

// Post
$router->get('/posts', 'PostsController@index');
$router->post('/posts', 'PostsController@store');
$router->get('/post/{id}', 'PostsController@show');
$router->put('/post/{id}', 'PostsController@update');

// Route yang wajib login
$router->group(['middleware' => ['auth']], function () use ($router) {
    $router->delete('/auth/logout', 'AuthController@logout');

    $router->get('/posts', 'PostsController@index');
    $router->post('/posts', 'PostsController@store');
    $router->get('/post/{id}', 'PostsController@show');
    $router->put('/post/{id}', 'PostsController@update');
    $router->delete('/post/{id}', 'PostsController@destroy');

    $router->get('/notes', 'NotesController@index');
    $router->post('/notes', 'NotesController@store');
    $router->get('/note/{id}', 'NotesController@show');
    $router->put('/note/{id}', 'NotesController@update');
    $router->delete('/note/{id}', 'NotesController@destroy');
});
// Product
$router->get('/products', 'ProductsController@index');
$router->post('/products', 'ProductsController@store');
$router->get('/product/{id}', 'ProductsController@show');
$router->put('/product/{id}', 'ProductsController@update');
$router->delete('/product/{id}', 'ProductsController@destroy');

// authentication
$router->group(['prefix' => 'auth'], function () use ($router) {
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
});