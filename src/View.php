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

        /* $content = file_get_contents($view);
        $compiledContent = preg_replace(['/{{/', '/ }}/'], ['<?php echo', '; ?>'], $content);
        $compiledContent = preg_replace(['/@for \((.*)\)/', '/@endfor/'], ['<?php for ($1) { ?>', '<?php } ?>'], $compiledContent);
        $compiled = __DIR__.'/../views/'.uniqid().'.compiled.php';
        file_put_contents($compiled, $compiledContent);
        include $compiled;
        unlink($compiled); */
    }

    public static function partial($partial)
    {
        require __DIR__.'/../views/'.$partial.'.html.php';
    }

    public static function notFound()
    {
        http_response_code(404);

        return self::render('404');
    }
}
