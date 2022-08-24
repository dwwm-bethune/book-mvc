<?php

namespace Book\Mvc\Controller;

use Book\Mvc\View;

abstract class Controller
{
    public function render($view, $data = [])
    {
        return View::render($view, $data);
    } 

    public function notFound()
    {
        return View::notFound();
    }

    public function redirect($url)
    {
        header('Location: '.$url);
    }

    public function post($key)
    {
        return $_POST[$key] ?? null;
    }

    public function submit()
    {
        return ! empty($_POST);
    }
}
