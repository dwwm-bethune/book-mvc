<?php

use M2i\Mvc\App;

require __DIR__.'/../vendor/autoload.php';

define('BASE_URL', '/book-mvc/public');

$app = new App();
$app->setBasePath(BASE_URL);

$app->addRoutes([
    ['GET', '/', 'HomeController@index'],
]);

$app->run();
