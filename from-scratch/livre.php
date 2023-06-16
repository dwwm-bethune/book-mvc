<?php
    require 'data.php';

    // Récupérer l'id du livre que l'on veut voir
    $id = $_GET['id'] ?? null;

    // On doit chercher le livre qui correspond dans le tableau (ou la base de données...)
    $query = database()->prepare('SELECT * FROM books WHERE id = :id');
    $query->execute(['id' => $id]);
    $book = $query->fetch();

    // foreach ($books as $bookIteration) {
    //     if ($bookIteration['id'] === (int) $id) {
    //         $book = $bookIteration;
    //     }
    // }

    // Gestion de la 404 s'il n'y a pas de livres
    if (!$book) {
        http_response_code(404);
        require '404.php';
        die();
    }

    $title = $book['title'];
    $price = $book['price']; // sans taxes
    $discount = $book['discount'];
    $isbn = $book['isbn']; // ISBN 13 ou 10 non formaté 2-7654-1005-4 ou 2-765412-005123
    $author = $book['author'];
    $publishedAt = $book['published_at'];
    $image = $book['image'];

    // Calcul du prix
    $realPrice = price($price);
    $discountPrice = price($price, $discount);

    // Calcul de l'ISBN
    $isbnFinal = isbn($isbn);
?>

<?php require 'header.php'; ?>

    <div class="max-w-5xl mx-auto px-3">
        <div class="lg:flex items-center">
            <div class="lg:w-1/2">
                <img class="rounded-lg max-w-full mx-auto mb-12" src="./<?= $image; ?>" alt="<?= $title; ?>">
            </div>
            <div class="lg:w-1/2">
                <h1 class="text-center text-2xl font-bold"><?= $title; ?></h1>

                <div class="flex items-center justify-between my-10">
                    <div>
                        <p class="text-4xl font-bold"><?= $discountPrice; ?> €</p>
                        <?php if ($discount > 0) { ?>
                        <p class="text-lg font-bold">-<?= $discount; ?>% <span class="line-through"><?= $realPrice; ?> €</span></p>
                        <?php } ?>
                    </div>
                    <div class="text-lg text-gray-900">
                        <p>
                            Par <strong><?= $author; ?></strong>
                        </p>
                        <p>
                            Publié le <?= date('d/m/Y', strtotime($publishedAt)); ?>
                        </p>
                    </div>
                </div>

                <p class="text-xl text-center text-gray-900">
                    ISBN: <strong><?= $isbnFinal; ?></strong>
                </p>

                <div class="text-center mt-12">
                    <a class="bg-gray-900 px-4 py-2 text-white inline-block rounded hover:bg-gray-700 duration-200" href="addCart.php?id=<?= $book['id']; ?>">
                        Ajouter au panier
                    </a>
                </div>
            </div>
        </div>
    </div>

<?php require 'footer.php'; ?>
