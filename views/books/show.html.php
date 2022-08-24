<?php self::partial('partials/header'); ?>

    <div class="max-w-5xl mx-auto px-3">
        <div class="lg:flex items-center">
            <div class="lg:w-1/2">
                <img class="rounded-lg max-w-full mx-auto mb-12" src="<?= $book->image(); ?>" alt="<?= $book->title; ?>">
            </div>
            <div class="lg:w-1/2">
                <h1 class="text-center text-2xl font-bold"><?= $book->title; ?></h1>

                <div class="flex items-center justify-between my-10">
                    <p class="text-4xl font-bold"><?= $book->price(); ?> €</p>
                    <div class="text-lg text-gray-900">
                        <p>
                            Par <strong><?= $book->author; ?></strong>
                        </p>
                        <p>
                            Publié le <?= $book->publishedAt(); ?>
                        </p>
                    </div>
                </div>

                <p class="text-xl text-center text-gray-900">
                    ISBN: <strong><?= $book->isbn; ?></strong>
                </p>
            </div>
        </div>
    </div>

<?php self::partial('partials/footer'); ?>
