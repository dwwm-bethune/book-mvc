<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title.' - Book PHP' : 'Book PHP'; ?></title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&display=swap">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
</head>
<body class="font-[Ubuntu]">
    <div class="max-w-5xl mx-auto px-3 mb-8">
        <div class="flex justify-between items-center py-6 border-b">
            <h2 class="text-3xl">
                <a href="<?= route('/'); ?>">Book PHP</a>
            </h2>
            <form class="relative" action="">
                <input type="text" name="search" class="px-3 pl-8 rounded-lg border-gray-300" value="<?= query('search'); ?>">
                <div class="absolute inset-y-0 left-0 flex items-center pl-2">
                    <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
            </form>
            <ul>
                <li>
                    <a class="px-4" href="<?= route('/'); ?>">Accueil</a>
                    <a class="px-4" href="<?= route('books'); ?>">Livres</a>
                    <a class="px-4" href="<?= route('/cart'); ?>">Panier (<?= array_sum(array_column($_SESSION['cart'] ?? [], 'quantity')); ?>)</a>
                    <a class="px-4" href="<?= route('/login'); ?>">Connexion</a>
                    <a class="px-4" href="<?= route('/a-propos'); ?>">A propos</a>
                </li>
            </ul>
        </div>
    </div>
