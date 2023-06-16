<?php

require 'data.php';

// Purger la table avant d'insérer les données
database()->query('TRUNCATE TABLE books');
database()->query('TRUNCATE TABLE users');

// Insérer dans la base...
// On prépare la requête pour la sécuriser (Injection SQL)
$query = database()->prepare(
    'INSERT INTO books (title, price, discount, isbn, author, published_at, image)
     VALUES (:title, :price, :discount, :isbn, :author, :published_at, :image)'
);

// On exécute la requête
foreach ($books as $book) {
    $query->execute([
        'title' => $book['title'],
        'price' => $book['price'],
        'discount' => $book['discount'],
        'isbn' => $book['isbn'],
        'author' => $book['author'],
        'published_at' => $book['published_at'],
        'image' => $book['image'],
    ]);
}

// Insérer 2 utilisateurs
$query = database()->prepare(
    'INSERT INTO users (email, password) VALUES (?, ?)'
);

$query->execute([
    'matthieu@boxydev.com', password_hash('password', PASSWORD_DEFAULT)
]);
$query->execute([
    'fiorella@boxydev.com', password_hash('password', PASSWORD_DEFAULT)
]);
