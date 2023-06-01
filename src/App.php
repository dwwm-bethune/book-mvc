<?php

namespace Book\Mvc;

use Book\Mvc\Model\User;

class App extends \AltoRouter
{
    public function run()
    {
        session_start();

        if (! isset($_SESSION['user']) && isset($_COOKIE['REMEMBER'])) {
            if ($user = User::findToken($_COOKIE['REMEMBER'])) {
                $_SESSION['user'] = $user;
            }
        }

        $match = $this->match();

        if (is_array($match)) {
            [$controller, $method] = explode('@', $match['target']);
            $controller = 'Book\\Mvc\\Controller\\'.$controller;
            $call = new $controller();
            $call->$method(...$match['params']);
        } else {
            View::notFound();
        }
    }
}
