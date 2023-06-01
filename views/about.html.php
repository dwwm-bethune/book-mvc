<?php self::partial('partials/header'); ?>

    <div class="max-w-5xl mx-auto">
        <h1 class="text-center text-2xl">A propos de <?= $name; ?></h1>

        <ul>
        <?php foreach ($testimonies as $testimony) { ?>
            <li>
                <?= $testimony->id; ?>:
                <?= $testimony->content; ?>
            </li>
        <?php } ?>
        </ul>
    </div>

<?php self::partial('partials/footer'); ?>
