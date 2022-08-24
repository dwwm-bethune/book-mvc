<?php

use Book\Mvc\App;

require __DIR__.'/../vendor/autoload.php';

define('BASE_URL', '/book-mvc/public');

$app = new App();
$app->setBasePath(BASE_URL);

$app->addRoutes([
    ['GET', '/', 'HomeController@index'],
    ['GET', '/books', 'BookController@index'],
    ['GET|POST', '/book/new', 'BookController@create'],
    ['GET', '/book/[:id]', 'BookController@show'],
]);

$app->run();
