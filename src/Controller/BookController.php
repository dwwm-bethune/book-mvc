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

    public function create()
    {
        $book = new Book();
        $errors = [];
        $success = false;

        if ($this->submit()) {
            $book->title = $this->post('title');
            $book->price = $this->post('price');
            $book->isbn = $this->post('isbn');
            $book->author = $this->post('author');
            $book->published_at = $this->post('published_at');
            $book->image = 'uploads/0'.rand(1, 6).'.jpg';

            if (empty($book->title)) {
                $errors['title'] = 'Le titre est invalide.';
            }

            if ($book->price < 0 || $book->price > 100) {
                $errors['price'] = 'Le prix est invalide.';
            }

            if (! $book->validIsbn()) {
                $errors['isbn'] = 'L\'ISBN est invalide.';
            }

            if (empty($book->author)) {
                $errors['author'] = 'L\'auteur est invalide.';
            }

            $publishedAt = explode('-', $book->published_at);
            if (!checkdate((int) ($publishedAt[1] ?? 0), (int) ($publishedAt[2] ?? 0), (int) ($publishedAt[0] ?? 0))) {
                $errors['published_at'] = 'La date est invalide.';
            }

            if (empty($errors)) {
                $success = $book->save();
            }
        }

        return $this->render('books/create', [
            'book' => $book,
            'errors' => $errors,
            'success' => $success,
        ]);
    }

    public function edit($id)
    {
        $book = Book::find($id);

        if (! $book) {
            return $this->notFound();
        }

        $errors = [];
        $success = false;

        if ($this->submit()) {
            $book->title = $this->post('title');
            $book->price = $this->post('price');
            $book->isbn = $this->post('isbn');
            $book->author = $this->post('author');
            $book->published_at = $this->post('published_at');
            $book->image = 'uploads/0'.rand(1, 6).'.jpg';

            if (empty($book->title)) {
                $errors['title'] = 'Le titre est invalide.';
            }

            if ($book->price < 0 || $book->price > 100) {
                $errors['price'] = 'Le prix est invalide.';
            }

            if (! $book->validIsbn()) {
                $errors['isbn'] = 'L\'ISBN est invalide.';
            }

            if (empty($book->author)) {
                $errors['author'] = 'L\'auteur est invalide.';
            }

            $publishedAt = explode('-', $book->published_at);
            if (!checkdate((int) ($publishedAt[1] ?? 0), (int) ($publishedAt[2] ?? 0), (int) ($publishedAt[0] ?? 0))) {
                $errors['published_at'] = 'La date est invalide.';
            }

            if (empty($errors)) {
                $success = $book->update();
            }
        }

        return $this->render('books/edit', [
            'book' => $book,
            'errors' => $errors,
            'success' => $success,
        ]);
    }

    public function delete($id)
    {
        Book::delete($id);

        $this->redirect(BASE_URL.'/books');
    }
}
