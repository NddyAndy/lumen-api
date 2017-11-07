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
    return response()->json(['msg' => 'Welcome to version of this unknown api']);
});

//user routes
$router->get('/users', 'UserController@index');
$router->post('/users', 'UserController@store');
$router->get('/users/{id}', 'UserController@show');
$router->put('/users/{id}', 'UserController@update');
$router->delete('/users/{id}', 'UserController@destroy');

$router->post('/register', 'AuthController@register');
$router->post('/login', 'AuthController@login');
$router->post('/logout', 'AuthController@logout');
$router->post('/refresh', 'AuthController@refresh');
$router->get('/profile', 'AuthController@authUser');
//post routes

$router->get('/posts', 'PostController@index');
$router->post('/posts', 'PostController@store');
$router->get('/posts/{id}', 'PostController@show');
$router->put('/posts/{id}', 'PostController@update');
$router->delete('/posts/{id}', 'PostController@destroy');

//comment routes

$router->get('/comments', 'CommentController@index');
$router->get('/comments/{id}', 'CommentController@show');

//comments of posts

$router->get('/posts/{id}/comments', 'PostCommentController@index');
$router->post('/posts/{id}/comments/', 'PostCommentController@store');
$router->put('/posts/{p_id}/comments/{c_id}', 'PostCommentController@update');
$router->delete('/posts/{p_id}/comments/{c_id}', 'PostCommentController@destroy');


