<?php

namespace Database\Seeders;

use App\Models\ProductToothpasteType;
use Illuminate\Database\Seeder;

class ProductToothpasteTypeSeeder extends Seeder {

    protected $product_with_toothpaste = [2, 4];

    public function run() {
        foreach ($this->product_with_toothpaste as $product_id) {
            for ($i = 1; $i <= 2; $i++)
                ProductToothpasteType::query()->create([
                    'product_id' => $product_id,
                    'toothpaste_type_id' => $i
                ]);
        }
    }

}
