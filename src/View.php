<?php

namespace Book\Mvc;

class View
{
    public static $data = [];

    public static function render($view, $data = [])
    {
        self::$data = $data;

        foreach ($data as $variable => $value) {
            $$variable = $value;
        }

        $view = __DIR__.'/../views/'.$view.'.html.php';

        if (!file_exists($view)) {
            throw new \Exception("La vue $view n'existe pas.");
        }

        include $view;
    }

    public static function partial($partial)
    {
        foreach (self::$data as $variable => $value) {
            $$variable = $value;
        }

        require __DIR__.'/../views/'.$partial.'.html.php';
    }

    public static function notFound()
    {
        http_response_code(404);

        return self::render('404');
    }
}
