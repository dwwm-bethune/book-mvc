<?php

namespace Book\Mvc\Controller;

use Book\Mvc\View;

class HomeController extends Controller
{
	public function index()
	{
		return View::render('home');
	}
}
