<?php

require 'data.php';

// Récupérer l'id du livre que l'on veut voir
$id = $_GET['id'] ?? null;

// On doit chercher le livre qui correspond dans le tableau (ou la base de données...)
$query = database()->prepare('SELECT * FROM books WHERE id = :id');
$query->execute(['id' => $id]);
$book = $query->fetch();

// Gestion de la 404 s'il n'y a pas de livres
if (!$book) {
    http_response_code(404);
    require '404.php';
    die();
}

addCart($book);

header('Location: ./cart.php');
