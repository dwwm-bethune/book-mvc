<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class UserSeeder extends AbstractSeed
{
    public function run()
    {
        $faker = Factory::create('fr_FR');
        $data = [
            [
                'email' => 'matthieu@boxydev.com',
                'password' => password_hash('password', PASSWORD_DEFAULT),
            ]
        ];

        for ($i = 0; $i < 9; $i++) {
            $data[] = [
                'email' => $faker->safeEmail(),
                'password' => password_hash('password', PASSWORD_DEFAULT),
            ];
        }

        $users = $this->table('users');
        $users->truncate();
        $users->insert($data)->saveData();
    }
}
