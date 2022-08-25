<?php

use Faker\Factory;
use Phinx\Seed\AbstractSeed;

class BookSeeder extends AbstractSeed
{
    public function run()
    {
        $faker = Factory::create('fr_FR');
        $data = [];

        for ($i = 0; $i < 10; $i++) {
            $data[] = [
                'title' => $faker->sentence(5),
                'price' => $faker->randomNumber(2),
                'isbn' => $faker->ean13(),
                'author' => $faker->name(),
                'published_at' => $faker->date(),
                'image' => 'uploads/0'.$faker->numberBetween(1, 6).'.jpg',
            ];
        }

        $books = $this->table('books');
        $books->truncate();
        $books->insert($data)->saveData();
    }
}
