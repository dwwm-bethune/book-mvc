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

    public function show($id)
    {
        $book = Book::find($id);

        if (! $book) {
            return $this->notFound();
        }

        return $this->render('books/show', [
            'book' => $book,
        ]);
    }
}
