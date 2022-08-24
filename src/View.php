<?php

namespace Book\Mvc;

class View
{
    public static function render($view, $data = [])
    {
        foreach ($data as $variable => $value) {
            $$variable = $value;
        }

        $view = __DIR__.'/../views/'.$view.'.html.php';

        if (!file_exists($view)) {
            throw new \Exception("La vue $view n'existe pas.");
        }

        include $view;
    }

    public static function notFound()
    {
        http_response_code(404);

        return self::render('404');
    }
}
