<?php

namespace Book\Mvc\Controller;

use Book\Mvc\View;

abstract class Controller
{
    public function notFound()
    {
        return View::notFound();
    }

    public function redirect($url)
    {
        header('Location: '.$url);
    }
}
