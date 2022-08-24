<?php

namespace M2i\Mvc\Controller;

use M2i\Mvc\View;

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
