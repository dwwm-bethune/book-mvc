<?php self::partial('partials/header'); ?>

    <div class="max-w-5xl mx-auto px-3">
        <div class="flex flex-wrap -mx-3">
            <?php foreach ($books as $book) { ?>
                <div class="w-1/2 lg:w-1/4 mb-6">
                    <div class="bg-white shadow-lg rounded-lg h-full mx-3">
                        <a href="<?= BASE_URL; ?>/book/<?= $book->id; ?>">
                            <img class="rounded-t-lg" src="<?= $book->image(); ?>" alt="<?= $book->title; ?>">
                            <div class="p-4">
                                <h2 class="text-center"><?= $book->title; ?></h2>
                                <p class="text-lg text-center font-bold"><?= $book->price(); ?> €</p>
                                <p class="text-xs text-center text-gray-400">
                                    Par <strong><?= $book->author; ?></strong> en <?= $book->year(); ?>
                                </p>
                                <p class="text-xs text-center text-gray-400">
                                    ISBN: <strong><?= $book->isbn; ?></strong>
                                </p>
                            </div>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

<?php self::partial('partials/footer'); ?>
