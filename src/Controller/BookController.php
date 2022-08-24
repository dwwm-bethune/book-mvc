<?php

namespace Book\Mvc\Controller;

use Book\Mvc\Model\Book;

class BookController extends Controller
{
    public function index()
    {
        return $this->render('books/list', [
            'books' => Book::all(),
        ]);
    }
}
