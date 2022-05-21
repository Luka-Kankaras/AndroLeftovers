<?php

namespace Database\Seeders;

use App\Models\ColorProduct;
use Illuminate\Database\Seeder;

class ColorProductSeeder extends Seeder {

    protected $products = [
//        1  => [true => [1, 2, 3]],
        1  => [true => [4, 5]],
        2  => [false => [5, 6]],
        3  => [false => [5, 6]],
    ];

    public function run() {
        foreach ($this->products as $product_id => $colors_and_type) {
            foreach ($colors_and_type as $type => $colors) {
                foreach ($colors as $color_id) {
                    ColorProduct::query()->create([
                        'product_id' => $product_id,
                        'color_id' => $color_id,
                        'is_toothbrush' => $type
                    ]);
                }
            }
        }
    }

}
