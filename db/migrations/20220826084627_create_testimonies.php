<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateTestimonies extends AbstractMigration
{
    public function change(): void
    {
        $this->table('testimonies')
            ->addColumn('content', 'text')
            ->addColumn('created_at', 'datetime')
            ->create();
    }
}
