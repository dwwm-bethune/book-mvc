<?php

namespace M2i\Mvc\Controller;

use M2i\Mvc\View;

class HomeController extends Controller
{
	public function index()
	{
		return View::render('home');
	}
}
