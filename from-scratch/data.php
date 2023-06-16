<?php

// Permet d'utiliser les sessions sur toutes nos pages
session_start();

/**
 * Permet de calculer un prix TTC avec une promotion ou pas.
 * On peut également formater le prix (1234.06 devient 1 234,06)
 */
function price($priceWithoutTaxes, $discount = 0, $format = true, $quantity = 1) {
    $priceWithTaxes = $priceWithoutTaxes * (1 + 20 / 100) * (1 - $discount / 100);
    $priceWithTaxes = round($priceWithTaxes, 2) * $quantity;

    if ($format) {
        $priceWithTaxes = number_format($priceWithTaxes, 2, ',', ' ');
    }

    return $priceWithTaxes;
}

/**
 * Permet de formater un ISBN proprement.
 * 1234567890 => 1-2345-6789-0
 * 1234567890123 => 1-234567-890123
 */
function isbn($isbn) {
    $isbnFinal = substr($isbn, 0, 1); // 8
    $isbnRest = substr($isbn, 1); // 248827583739
    // 13 - 1 / 2 == 6 et 10 - 1 / 2 == 4 (avec le floor arrondi à l'entier inférieur)
    $isbnRest = str_split($isbnRest, floor((strlen($isbn) - 1) / 2)); // ['248827', '583739']
    $isbnRest = implode('-', $isbnRest); // 248827-583739
    $isbnFinal .= '-'.$isbnRest; // 8-248827-583739

    return $isbnFinal;
}

/**
 * Fonction qui permet de se connecter à MySQL (PDO).
 */
function database() {
    $db = new PDO('mysql:host=localhost;dbname=book-php', 'root', '', []);

    return $db;
}

/**
 * Fonction qui permet de nettoyer les données utilisateurs.
 */
function sanitize($value) {
    // '<script>toto</script>' => htmlspecialchars
    // 'password    ' => trim enlève les espaces
    return trim(htmlspecialchars($value ?? ''));
}

/**
 * Permet de récupérer une donnée dans $_POST
 */
function post($key) {
    return sanitize($_POST[$key] ?? null);
}

/**
 * Permet de savoir si un formulaire est envoyé
 */
function isSubmitted() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

/**
 * Permet de faire un SELECT préparé
 */
function select($sql, $parameters = []) {
    $query = database()->prepare($sql);
    $query->execute($parameters);

    return $query->fetch();
}

/**
 * Permet de faire un INSERT préparé
 */
function insert($sql, $parameters = []) {
    $query = database()->prepare($sql);
    $query->execute($parameters);
}

/**
 * Permet de retrouver l'utilisateur connecté.
 */
function user() {
    // Si un cookie est présent, on reconnecte l'user
    if (isset($_COOKIE['remember']) && !isset($_SESSION['user'])) {
        $query = database()->prepare('SELECT * FROM users WHERE token = :token');
        $query->execute(['token' => $_COOKIE['remember']]);
        $user = $query->fetch();

        if ($user) {
            $_SESSION['user'] = $user['email'];
        }
    }

    return $_SESSION['user'] ?? null;
}

/**
 * Permet d'ajouter / modifier un produit dans le panier
 */
function addCart($book) {
    $cart = cart();

    $exists = false;

    // On regarde si le produit existe dans le tableau et on modifie sa quantité
    // Le & permet de modifier un élément du tableau par référence
    foreach ($cart as &$item) {
        if ($item['book']['id'] === $book['id']) {
            $item['quantity'] += 1;
            $exists = true;
        }
    }

    // Si le produit n'existe pas déjà dans le panier, on l'ajoute
    if (! $exists) {
        $cart[] = ['book' => $book, 'quantity' => 1];
    }

    $_SESSION['cart'] = $cart;
} 

 /**
 * Permet de retirer un produit dans le panier
 */
function removeCart($id) {
    $cart = cart();

    foreach ($cart as $key => $item) {
        if ($item['book']['id'] === $id) {
            unset($cart[$key]);
        }
    }

    $_SESSION['cart'] = $cart;
}

/**
 * Permet de retrouver le panier
 */
function cart() {
    global $books;

    return $_SESSION['cart'] ?? [
        ['book' => $books[0], 'quantity' => 2],
        ['book' => $books[1], 'quantity' => 3],
    ];
}

/**
 * Permet de retrouver le total du panier
 */
function totalCart() {
    $total = array_sum(array_map(function ($item) {
        return price($item['book']['price'], $item['book']['discount'], false, $item['quantity']);
    }, cart()));

    return number_format($total, 2, ',', ' ');
}

$books = [
    [
        'id' => 1,
        'title' => 'Quae dolor itaque natus reiciendis ad quae.',
        'price' => 38,
        'discount' => 19,
        'isbn' => '8248827583739',
        'author' => 'Denise-Sabine Bernard',
        'published_at' => '2014-08-18',
        'image' => 'uploads/06.jpg',
    ],
    [
        'id' => 2,
        'title' => 'In in facilis quam vitae.',
        'price' => 26,
        'discount' => 0,
        'isbn' => '3680780915',
        'author' => 'Nicolas de la Courtois',
        'published_at' => '1987-10-22',
        'image' => 'uploads/05.jpg',
    ],
    [
        'id' => 3,
        'title' => 'Dolorum sit veritatis atque rerum cum quaerat.',
        'price' => 78,
        'discount' => 20,
        'isbn' => '0432990694820',
        'author' => 'Aimé Martineau',
        'published_at' => '2008-08-07',
        'image' => 'uploads/02.jpg',
    ],
    [
        'id' => 4,
        'title' => 'Illo deleniti commodi ex.',
        'price' => 29,
        'discount' => 18,
        'isbn' => '7445094667310',
        'author' => 'Arthur Allard',
        'published_at' => '1991-07-23',
        'image' => 'uploads/01.jpg',
    ],
    [
        'id' => 5,
        'title' => 'Et modi sit dolorum.',
        'price' => 45,
        'discount' => 18,
        'isbn' => '0857622132295',
        'author' => 'Alphonse Gros',
        'published_at' => '1981-10-04',
        'image' => 'uploads/02.jpg',
    ],
    [
        'id' => 6,
        'title' => 'Quam iusto natus eos.',
        'price' => 62,
        'discount' => 11,
        'isbn' => '9478341825490',
        'author' => 'Théodore Francois',
        'published_at' => '2013-02-09',
        'image' => 'uploads/03.jpg',
    ],
    [
        'id' => 7,
        'title' => 'Natus possimus modi sint hic ut tempore.',
        'price' => 68,
        'discount' => 10,
        'isbn' => '0873356029069',
        'author' => 'René Joly',
        'published_at' => '1996-01-30',
        'image' => 'uploads/06.jpg',
    ],
    [
        'id' => 8,
        'title' => 'Maxime vel ut similique.',
        'price' => 25,
        'discount' => 10,
        'isbn' => '0593548548504',
        'author' => 'Henriette Gomes',
        'published_at' => '1975-08-20',
        'image' => 'uploads/05.jpg',
    ],
    [
        'id' => 9,
        'title' => 'Quia officia dignissimos et natus a.',
        'price' => 50,
        'discount' => 11,
        'isbn' => '1309708700366',
        'author' => 'Guillaume Leleu',
        'published_at' => '2021-09-29',
        'image' => 'uploads/05.jpg',
    ],
    [
        'id' => 10,
        'title' => 'Enim et omnis aliquid.',
        'price' => 60,
        'discount' => 14,
        'isbn' => '1223719243691',
        'author' => 'Louise Guyon',
        'published_at' => '1994-04-24',
        'image' => 'uploads/05.jpg',
    ],
];
