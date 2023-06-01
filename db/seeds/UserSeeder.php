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
                'token' => $faker->regexify('[a-z0-9]{64}'),
            ]
        ];

        for ($i = 0; $i < 9; $i++) {
            $data[] = [
                'email' => $faker->safeEmail(),
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'token' => $faker->regexify('[a-z0-9]{64}'),
            ];
        }

        $users = $this->table('users');
        $users->truncate();
        $users->insert($data)->saveData();
    }
}
