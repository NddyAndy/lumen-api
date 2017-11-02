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

$router->get('/', function () {
    return response()->json(['msg' => 'Welcome to version of this unknown api']);
});

//user routes
$router->get('/users', 'UserController@index');
$router->post('/users', 'UserController@store');
$router->get('/users/{id}', 'UserController@show');
$router->put('/users/{id}', 'UserController@update');
$router->delete('/user/{id}', 'UserController@destroy');

//post routes

$router->get('/postss', 'PostController@index');
$router->post('/posts', 'PostController@store');
$router->get('/posts/{id}', 'PostController@show');
$router->put('/posts/{id}', 'PostController@update');
$router->delete('/posts/{id}', 'PostController@destroy');

//comment routes

$router->get('/comments', 'CommentController@index');
$router-get('/commments/{id}', 'CommentController@show');

//comments of posts

$router->get('/posts/{id}/comments', 'PostCommentController@index');
$router->post('/posts/{id}/comments/', 'PostCommentController@store');
$router->put('/posts/{id}/comments/{id}', 'PostCommentController@update');
$router->delete('/post/{id}/comments/{id}', 'PostCommentControllar@destroy');


