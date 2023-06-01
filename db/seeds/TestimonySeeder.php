<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class TestimonySeeder extends AbstractSeed
{
    public function run()
    {
        $faker = Factory::create('fr_FR');
        $data = [];

        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'content' => $faker->sentence(5),
                'created_at' => $faker->date(),
            ];
        }

        $testimonies = $this->table('testimonies');
        $testimonies->truncate();
        $testimonies->insert($data)->saveData();
    }
}
