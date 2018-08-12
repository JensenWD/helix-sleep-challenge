<?php

//
//$router->get('/', function () use ($router) {
//    return $router->app->version();
//});

$router->group(['middleware' => 'auth'], function () use ($router) {
    $router->group(['prefix' => 'products'], function () use ($router) {
        $router->get('', 'ProductController@index');
        $router->post('', 'ProductController@store');
        $router->get('{id}', 'ProductController@show');
        $router->delete('{id}', 'ProductController@destroy');
        $router->put('{id}', 'ProductController@update');
        $router->post('{id}/image', 'ProductController@addImage');
    });

    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->get('{uid}/products', 'ProductUserController@index');
        $router->post('{uid}/product/{pid}', 'ProductUserController@store');
        $router->delete('{uid}/product/{pid}', 'ProductUserController@destroy');
    });
});
