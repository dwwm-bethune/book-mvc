<?php

namespace Book\Mvc\Controller;

use Book\Mvc\Model\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::all();

        if ($search = query('search')) {
            $books = array_filter($books, function ($book) use ($search) {
                return str_contains($book->title, $search);
            });
        }

        return $this->render('books/list', [
            'books' => $books,
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
            'title' => $book->title,
        ]);
    }

    public function create()
    {
        $book = new Book();
        $errors = [];
        $success = false;

        if (isSubmitted()) {
            $book->title = request('title');
            $book->price = request('price');
            $book->discount = request('discount');
            $book->isbn = request('isbn');
            $book->author = request('author');
            $book->published_at = request('published_at');
            $image = uploaded('image');

            if (empty($book->title)) {
                $errors['title'] = 'Le titre est invalide.';
            }

            if ($book->price < 0 || $book->price > 100) {
                $errors['price'] = 'Le prix est invalide.';
            }

            if (!empty($book->discount) && ($book->discount < 0 || $book->discount > 100)) {
                $errors['discount'] = 'La promotion est invalide.';
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

            $mimeTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
            if ($image['error'] !== 0) {
                $errors['image'] = 'L\'image est invalide.';
            } else {
                $mime = mime_content_type($image['tmp_name']);

                if (!in_array($mime, $mimeTypes)) {
                    $errors['image'] = 'L\'image est invalide.';
                }

                if ($image['size'] > 5 * 1024 * 1024) {
                    $errors['image'] = 'Le fichier est trop lourd (5 Mo).';
                }
            }

            if (empty($errors)) {
                $folder = __DIR__.'/../../public/uploads';

                if (!is_dir($folder)) { // Si le dossier n'existe pas, on le créé
                    mkdir($folder);
                }

                // Fiorella-1234 devient 91ca106ff0e1537a4c266ca1626c71ba
                $name = md5($book->title.'-'.uniqid());
                $extension = substr(strrchr($image['name'], '.'), 1); // jpg
                // 91ca106ff0e1537a4c266ca1626c71ba.jpg
                $filename = $name.'.'.$extension;

                // Upload du fichier
                move_uploaded_file($image['tmp_name'], $folder.'/'.$filename);

                $book->image = 'uploads/'.$filename;

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

        if (isSubmitted()) {
            $book->title = request('title');
            $book->price = request('price');
            $book->discount = request('discount');
            $book->isbn = request('isbn');
            $book->author = request('author');
            $book->published_at = request('published_at');
            $image = uploaded('image');

            if (empty($book->title)) {
                $errors['title'] = 'Le titre est invalide.';
            }

            if ($book->price < 0 || $book->price > 100) {
                $errors['price'] = 'Le prix est invalide.';
            }

            if ($book->discount > 100) {
                $errors['discount'] = 'La promotion est invalide.';
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

            $mimeTypes = ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'];
            if (! empty($image['tmp_name'])) {
                $mime = mime_content_type($image['tmp_name']);

                if (!in_array($mime, $mimeTypes)) {
                    $errors['image'] = 'L\'image est invalide.';
                }

                if ($image['size'] > 5 * 1024 * 1024) {
                    $errors['image'] = 'Le fichier est trop lourd (5 Mo).';
                }
            }

            if (empty($errors)) {
                if (! empty($image['tmp_name'])) {
                    $folder = __DIR__.'/../../public/uploads';

                    if (!is_dir($folder)) { // Si le dossier n'existe pas, on le créé
                        mkdir($folder);
                    }

                    if ($book->image) {
                        @unlink($folder.'/'.str_replace('uploads/', '', $book->image));
                    }

                    // Fiorella-1234 devient 91ca106ff0e1537a4c266ca1626c71ba
                    $name = md5($book->title.'-'.uniqid());
                    $extension = substr(strrchr($image['name'], '.'), 1); // jpg
                    // 91ca106ff0e1537a4c266ca1626c71ba.jpg
                    $filename = $name.'.'.$extension;

                    // Upload du fichier
                    move_uploaded_file($image['tmp_name'], $folder.'/'.$filename);

                    $book->image = 'uploads/'.$filename;
                }

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

        $folder = __DIR__.'/../../public';
        @unlink($folder.'/'.Book::find($id)->image);

        redirect(route('/books'));
    }
}
