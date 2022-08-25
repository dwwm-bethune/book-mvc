<?php

namespace Book\Mvc;

class App extends \AltoRouter
{
    public function run()
    {
        session_start();

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
