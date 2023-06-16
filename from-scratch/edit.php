<?php
    require 'data.php';

    // Si on est pas connecté, on redirige vers le login
    if (!user()) {
        header('Location: ./login.php');
    }

    // Récupérer l'id du livre que l'on veut modifier
    $id = $_GET['id'] ?? null;

    // On va chercher le livre
    $query = database()->prepare('SELECT * FROM books WHERE id = :id');
    $query->execute(['id' => $id]);
    $book = $query->fetch();

    // Gestion de la 404 s'il n'y a pas de livres
    if (!$book) {
        http_response_code(404);
        require '404.php';
        die();
    }

    // Traitement du formulaire (Récupérer les données)
    $title = sanitize($_POST['title'] ?? $book['title']);
    $price = sanitize($_POST['price'] ?? $book['price']);
    $discount = sanitize($_POST['discount'] ?? $book['discount']);
    $isbn = sanitize($_POST['isbn'] ?? $book['isbn']);
    $author = sanitize($_POST['author'] ?? $book['author']);
    $publishedAt = sanitize($_POST['published_at'] ?? $book['published_at']);
    $image = $_FILES['image'] ?? null;

    // var_dump($title, $price, $_POST);
    // echo $_SERVER['REQUEST_METHOD']; // Affiche la méthode (GET ou POST)

    // Vérifier les données
    $errors = [];
    $success = false;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { // On vérifie que le formulaire est soumis
        // Vérifier chaque champs...
        if (empty($title)) {
            $errors['title'] = 'Le titre est invalide.';
        }

        if ($price < 1 || $price > 100) {
            $errors['price'] = 'Le prix doit être entre 1 et 100.';
        }

        if ($discount && !($discount > 0 && $discount < 100)) {
            $errors['discount'] = 'La promotion doit être entre 0 et 100.';
        }

        if (strlen($isbn) !== 10 && strlen($isbn) !== 13 || !is_numeric($isbn)) {
            $errors['isbn'] = 'L\'ISBN doit faire 10 ou 13 chiffres.';
        }

        $authors = ['toto', 'titi', 'tata'];
        // if (!in_array($author, $authors)) {
        if (empty($author)) {
            $errors['author'] = 'L\'auteur est invalide. ('.implode(', ', $authors).' ou ce que vous voulez)';
        }

        $published = new DateTime($publishedAt);
        $now = new DateTime('today'); // Aujourd'hui sans les heures

        if ($published >= $now) {
            $errors['published_at'] = 'La date doit être antérieure à aujourd\'hui.';
        }

        if ($image['error'] === 0) {
            // Récupérer le type du fichier
            $mime = mime_content_type($image['tmp_name']);
            $mimeTypes = ['image/jpeg', 'image/png'];

            if (!in_array($mime, $mimeTypes)) {
                $errors['image'] = 'L\'image est invalide.';
            }

            // 35 * 1024 = 35ko
            // 3 * 1024 * 1024 = 3Mo
            if ($image['size'] > 3 * 1024 ** 2) {
                $errors['image'] = 'L\'image doit faire 35ko maximum.';
            }
        }

        // Si aucune erreurs, alors on fait quelque chose (envoi mail, base de données, message)
        if (empty($errors)) {
            // Faire l'upload
            // Générer le nom du fichier (cat.jpg devient cat-123.jpg)
            if ($image['error'] === 0) {
                $path = pathinfo($image['name']); // ['cat', 'jpg']
                $name = $path['filename'].'-'.uniqid().'.'.$path['extension'];
                move_uploaded_file($image['tmp_name'], './uploads/'.$name);

                // Et on supprime le fichier actuel ?
                @unlink($book['image']);
            } else {
                $name = basename($book['image']); // Image par défaut si pas d'image en upload
            }

            // Faire une requête SQL
            $query = database()->prepare(
                'UPDATE books SET title = :title, price = :price, discount = :discount, isbn = :isbn, author = :author, published_at = :published_at, image = :image
                WHERE id = :id'
            );
            $success = $query->execute([
                'title' => $title,
                'price' => $price,
                'discount' => $discount,
                'isbn' => $isbn,
                'author' => $author,
                'published_at' => $publishedAt,
                'image' => 'uploads/'.$name,
                'id' => $id,
            ]);

            // Ajout du message flash
            $_SESSION['message'] = 'Votre livre a bien été modifié.';

            // Rediriger l'utilisateur vers la liste
            header('Location: ./livres.php');
        }
    }
?>

<?php require 'header.php'; ?>

    <div class="max-w-5xl mx-auto px-3">
        <div>
            <?php for ($i = 1; $i <= 6; $i++) { ?>
                <img src="./uploads/0<?= $i; ?>.jpg" alt=""
                    class="images inline absolute top-0 left-0 -z-10 w-screen h-screen duration-500">
            <?php } ?>
        </div>

        <?php if (!empty($errors)) { ?>
        <div class="bg-red-300 p-5 rounded border border-red-800 text-red-800 my-4">
            <?php foreach ($errors as $error) { ?>
                <p><?= $error; ?></p>
            <?php } ?>
        </div>
        <?php } ?>

        <?php if ($success) { ?>
            <p class="bg-green-300 p-5 text-green-800 mb-4 w-1/2 mx-auto">Votre livre a bien été modifié.</p>
        <?php } ?>

        <form action="" method="post" class="w-1/2 mx-auto" enctype="multipart/form-data">
            <div class="mb-4">
                <label for="title" class="block">Titre *</label>
                <input type="text" name="title" id="title" class="border-0 border-b focus:ring-0 w-full" value="<?= $title; ?>">
            </div>
            <div class="mb-4">
                <label for="price" class="block">Prix *</label>
                <input type="text" name="price" id="price" class="border-0 border-b focus:ring-0 w-full" value="<?= $price; ?>">
            </div>
            <div class="mb-4">
                <label for="discount" class="block">Promotion</label>
                <input type="text" name="discount" id="discount" class="border-0 border-b focus:ring-0 w-full" value="<?= $discount; ?>">
            </div>
            <div class="mb-4">
                <label for="isbn" class="block">ISBN *</label>
                <input type="text" name="isbn" id="isbn" class="border-0 border-b focus:ring-0 w-full" value="<?= $isbn; ?>">
            </div>
            <div class="mb-4">
                <label for="author" class="block">Auteur *</label>
                <input type="text" name="author" id="author" class="border-0 border-b focus:ring-0 w-full" value="<?= $author; ?>">
            </div>
            <div class="mb-4">
                <label for="published_at" class="block">Publié le *</label>
                <input type="date" name="published_at" id="published_at" class="border-0 border-b focus:ring-0 w-full" value="<?= $publishedAt; ?>">
            </div>
            <div class="mb-4">
                <label for="image" class="block mb-2">Image *</label>
                <input type="file" name="image" id="image" class="cursor-pointer w-full
                    file:rounded-full file:border-0 file:cursor-pointer
                    file:bg-blue-50 hover:file:bg-blue-100
                    file:font-semibold file:py-2 file:px-4 file:mr-4
                ">

                <?php if ($book['image']) { ?>
                    <img class="rounded-lg max-w-full mx-auto mb-12 w-40" src="./<?= $book['image']; ?>" alt="<?= $book['title']; ?>">
                <?php } ?>
            </div>

            <div class="text-center">
                <button class="bg-gray-900 px-4 py-2 text-white inline-block rounded hover:bg-gray-700 duration-200">Modifier</button>
            </div>
        </form>
    </div>
    <script src="app.js"></script>

<?php require 'footer.php'; ?>
