<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory;

class ProductSeeder extends Seeder {


//    private $names = ['Colourful', 'Starter Pack', 'Annual plan', 'Toothbrush head', 'Toothpaste'];
    private $names = ['Starter Pack', 'Annual plan', 'Toothbrush head', 'Toothpaste'];

    public function run() {

        $faker = Factory::create();

        foreach ($this->names as $name) {
            Product::query()->create([
                'name' => $name,
                'buy_url' => 'https://google.com',
                'description' => $faker->text,
                'price' => $faker->randomFloat(2, 50, 150),
                'discount' => $faker->randomElement([0, 20, 50, 60]),
                "image" => asset('/test-photo.jpg'),
                'ivmax_toothbrush_count' => $name == 'Colourful' || $name == 'Starter Pack' ? 1 : 0,
                'brush_head_count' => $name == 'Colourful' || $name == 'Starter Pack' ? 1 : 0,
                'toothpaste_cartridges_count' => $name == 'Colourful' || $name == 'Starter Pack' ? 2 : 0,
            ]);
        }

    }

}
