<?php
declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateUsers extends AbstractMigration
{
    public function change(): void
    {
        $this->table('users')
            ->addColumn('email', 'string')
            ->addColumn('password', 'string')
            ->addColumn('token', 'string')
            ->create();
    }
}
