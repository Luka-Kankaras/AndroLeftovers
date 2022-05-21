<?php

namespace Database\Seeders;

use App\Models\ProductToothbrushType;
use Illuminate\Database\Seeder;

class ProductToothbrushTypeSeeder extends Seeder {

    public function run() {
        for ($i = 1; $i <= 3; $i++)
            for ($j = 1; $j <= 2; $j++)
                ProductToothbrushType::query()->create([
                    'product_id' => $i,
                    'toothbrush_type_id' => $j,
                ]);
    }

}
