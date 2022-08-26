<!DOCTYPE html>
<html>
<head>
    <title>Book MVC</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&display=swap">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
</head>
<body class="font-[Ubuntu]">
    <div class="max-w-5xl mx-auto px-3 mb-8">
        <div class="flex justify-between items-center py-6 border-b">
            <h2 class="text-3xl">
                <a href="<?= BASE_URL; ?>/">Book MVC</a>
            </h2>
            <ul>
                <li>
                    <a class="px-4" href="<?= BASE_URL; ?>/">Accueil</a>
                    <a class="px-4" href="<?= BASE_URL; ?>/books">Livres</a>
                    <a class="px-4" href="<?= BASE_URL; ?>/cart">Panier (<?= array_sum(array_column($_SESSION['cart'] ?? [], 'quantity')); ?>)</a>
                    <a class="px-4" href="<?= BASE_URL; ?>/a-propos">A propos</a>
                </li>
            </ul>
        </div>
    </div>
