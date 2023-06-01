<?php

use Book\Mvc\App;

require __DIR__.'/../vendor/autoload.php';

$app = new App();
$app->setBasePath(basePath());

$app->addRoutes([
    ['GET', '/', 'HomeController@index'],

    ['GET', '/books', 'BookController@index'],
    ['GET|POST', '/book/new', 'BookController@create'],
    ['GET', '/book/[:id]', 'BookController@show'],
    ['GET|POST', '/book/[:id]/edit', 'BookController@edit'],
    ['GET', '/book/[:id]/delete', 'BookController@delete'],

    ['GET', '/cart', 'CartController@index'],
    ['GET', '/cart/[:id]/add', 'CartController@create'],
    ['GET', '/cart/[:id]/delete', 'CartController@delete'],

    ['GET', '/a-propos', 'AboutController@index'],

    ['GET|POST', '/login', 'AuthController@login'],
    ['GET|POST', '/register', 'AuthController@register'],
    ['GET', '/logout', 'AuthController@logout'],
]);

$app->run();
