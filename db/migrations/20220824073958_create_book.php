<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateBook extends AbstractMigration
{
    public function change(): void
    {
        $this->table('books')
            ->addColumn('title', 'string')
            ->addColumn('price', 'integer')
            ->addColumn('discount', 'integer')
            ->addColumn('isbn', 'string')
            ->addColumn('author', 'string')
            ->addColumn('published_at', 'date')
            ->addColumn('image', 'string', ['null' => true])
            ->create();
    }
}
