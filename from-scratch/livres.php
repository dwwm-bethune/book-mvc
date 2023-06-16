<?php
    // Inclure un fichier php externe pour ranger son code et le réutiliser
    require 'data.php';
    
    // Est-ce qu'une recherche a eu lieu ?
    $search = htmlspecialchars($_GET['search'] ?? '');

    // Pour le tri
    $orderBy = sanitize($_GET['order_by'] ?? 'id'); // title
    $direction = sanitize($_GET['direction'] ?? 'DESC'); // DESC
    $orderBy = (in_array($orderBy, ['id', 'title', 'price'])) ? $orderBy : 'id';
    $direction = (strtoupper($direction) === 'ASC') ? 'ASC' : 'DESC';

    // Maintenant, pour avoir les livres, on va faire une requête sur la BDD...
    // $books = database()->query('SELECT * FROM books ORDER BY id DESC')->fetchAll();
    $query = database()->prepare("SELECT * FROM books WHERE title LIKE :search ORDER BY $orderBy $direction");
    $query->execute(['search' => "%$search%"]);
    $books = $query->fetchAll();

    // Fix pour trier les prix avec promotion
    if ($orderBy === 'price') {
        uasort($books, function ($book1, $book2) {
            $price1 = price($book1['price'], $book1['discount'], false);
            $price2 = price($book2['price'], $book2['discount'], false);

            return $price1 < $price2 ? -1 : 1;
        });
    }

    // On va filtrer le tableau de livres s'il y a une recherche
    // $searchBooks = [];

    // foreach ($books as $book) {
    //     // Est-ce que sit est présent dans le titre du livre ?
    //     if (str_contains(strtolower($book['title']), strtolower($search))) {
    //         $searchBooks[] = $book;
    //     }
    // }

    // Solution alternative
    // var_dump(array_filter($books, function ($book) {
    //     return str_contains($book['title'], 'sit'); // Est-ce que sit est présent dans le titre du livre ?
    // }));

    // $books = $searchBooks;

    // Filtre sur le prix max...
    $maxPrice = htmlspecialchars($_GET['max_price'] ?? '');
    $filterBooks = [];

    foreach ($books as $book) {
        // Si on a pas définit de maxPrice, on garde le livre
        // Si on a définit un maxPrice, on garde le livre inférieur au maxPrice
        // if (empty($maxPrice) || $book['price'] * 1.2 * (1 - $book['discount'] / 100) <= $maxPrice) {
        if (empty($maxPrice) || price($book['price'], $book['discount'], false) <= $maxPrice) {
            $filterBooks[] = $book;
        }
    }

    $books = $filterBooks;
?>

<?php require 'header.php'; ?>

    <div class="max-w-5xl mx-auto px-3">
        <div class="text-center mb-8">
            <a class="bg-gray-900 px-4 py-2 text-white inline-block rounded hover:bg-gray-700 duration-200" href="form.php">
                Créer un livre
            </a>
        </div>

        <?php if ($search) { ?>
        <div class="mb-6 text-center text-2xl">
            Vous avez cherché "<?= $search; ?>".
            Nous avons <?= count($books); ?> résultats.
        </div>
        <?php } ?>

        <form action="">
            <div class="flex justify-between items-center mb-8">
                <div>
                    <label for="order_by">Trier par</label>
                    <select class="rounded-lg border-gray-300" name="order_by" id="order_by">
                        <option value="id" <?= $orderBy === 'id' ? 'selected' : ''; ?>>Id</option>
                        <option value="title" <?= $orderBy === 'title' ? 'selected' : ''; ?>>Nom</option>
                        <option value="price" <?= $orderBy === 'price' ? 'selected' : ''; ?>>Prix</option>
                    </select>
                </div>

                <div>
                    <label for="direction">Direction</label>
                    <select class="rounded-lg border-gray-300" name="direction" id="direction">
                        <option value="asc" <?= $direction === 'ASC' ? 'selected' : ''; ?>>Asc</option>
                        <option value="desc" <?= $direction === 'DESC' ? 'selected' : ''; ?>>Desc</option>
                    </select>
                </div>

                <div>
                    <label for="min_price">Prix min</label>
                    <input type="text" class="rounded-lg border-gray-300" name="min_price" id="min_price">
                </div>

                <div>
                    <label for="max_price">Prix max</label>
                    <input type="text" class="rounded-lg border-gray-300" name="max_price" id="max_price" value="<?= $maxPrice; ?>">
                </div>

                <button class="bg-gray-900 px-4 py-2 text-white inline-block rounded hover:bg-gray-700 duration-200">Filtrer</button>
            </div>
        </form>

        <?php if (isset($_SESSION['message'])) {
            $message = $_SESSION['message'];
            unset($_SESSION['message']); // Efface le message flash
        ?>
            <p class="bg-green-300 p-5 text-green-800 mb-4 w-1/2 mx-auto"><?= $message; ?></p>
        <?php } ?>

        <div class="flex flex-wrap -mx-3">
            <?php foreach ($books as $book) {
                // Calcul du prix
                $realPrice = price($book['price']);
                $discountPrice = price($book['price'], $book['discount']);

                // Calcul de l'ISBN
                $isbnFinal = isbn($book['isbn']);
            ?>
            <div class="w-1/2 lg:w-1/4 mb-6">
                <div class="shadow-lg rounded-lg h-full mx-3">
                    <div class="flex flex-col justify-between h-full">
                        <a href="./livre.php?id=<?= $book['id']; ?>">
                            <img class="rounded-t-lg" src="./<?= $book['image']; ?>" alt="<?= $book['title']; ?>">
                            <div class="p-4">
                                <h2 class="text-center"><?= $book['title']; ?></h2>
                                <div class="flex justify-around items-center">
                                    <p class="text-lg font-bold"><?= $discountPrice; ?> €</p>
                                    <?php if ($book['discount'] > 0) { ?>
                                    <p class="text-xs font-bold">-<?= $book['discount']; ?>% <span class="line-through"><?= $realPrice; ?> €</span></p>
                                    <?php } ?>
                                </div>
                                <p class="text-xs text-center text-gray-400">
                                    Par <strong><?= $book['author']; ?></strong> en <?= date('Y', strtotime($book['published_at'])); ?>
                                </p>
                                <p class="text-xs text-center text-gray-400">
                                    ISBN: <strong><?= $isbnFinal; ?></strong>
                                </p>
                            </div>
                        </a>

                        <div class="text-center">
                            <a class="bg-gray-900 px-4 py-2 text-white inline-block rounded hover:bg-gray-700 duration-200 mb-4" href="edit.php?id=<?= $book['id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L6.832 19.82a4.5 4.5 0 01-1.897 1.13l-2.685.8.8-2.685a4.5 4.5 0 011.13-1.897L16.863 4.487zm0 0L19.5 7.125" />
                                </svg>
                            </a>
                            <a class="bg-red-700 px-4 py-2 text-white inline-block rounded hover:bg-red-500 duration-200 mb-4" href="delete.php?id=<?= $book['id']; ?>">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>

<?php require 'footer.php'; ?>
