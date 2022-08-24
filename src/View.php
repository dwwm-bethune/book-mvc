<?php

namespace Book\Mvc;

class View
{
    public static function render($template, $data = [])
    {
        foreach ($data as $variable => $value) {
            $$variable = $value;
        }

        $view = __DIR__.'/../views/'.$template.'.html.php';

        if (!file_exists($view)) {
            throw new \Exception("Le template $template n'existe pas.");
        }

        include $view;
    }

    public static function notFound()
    {
        http_response_code(404);

        return self::render('404');
    }
}
