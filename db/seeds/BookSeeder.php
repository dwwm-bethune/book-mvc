<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class BookSeeder extends AbstractSeed
{
    public function run()
    {
        $faker = Factory::create('fr_FR');

        $data = [
            [
                'title' => $faker->sentence(5),
                'price' => $faker->randomNumber(2),
                'isbn' => $faker->ean13(),
                'author' => $faker->name(),
                'published_at' => $faker->date(),
                'image' => null,
            ],
        ];

        $this->table('books')->insert($data)->saveData();
    }
}
