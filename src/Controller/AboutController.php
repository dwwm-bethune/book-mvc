<?php

namespace Book\Mvc\Controller;

use Book\Mvc\Model\Testimony;

class AboutController extends Controller
{
    public function index()
    {
        $name = 'M2I';

        return $this->render('about', [
            'name' => $name,
            'testimonies' => Testimony::all(),
        ]);
    }
}
