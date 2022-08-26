<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class TestimonySeeder extends AbstractSeed
{
    public function run()
    {
        $faker = Factory::create('fr_FR');

        $this->table('testimonies')->insert([
            ['content' => 'Super site', 'created_at' => $faker->date()],
            ['content' => 'Un bon site', 'created_at' => $faker->date()]
        ])->saveData();
    }
}
