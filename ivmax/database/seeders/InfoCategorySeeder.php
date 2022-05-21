<?php

namespace Database\Seeders;

use App\Models\InfoCategory;
use Illuminate\Database\Seeder;

class InfoCategorySeeder extends Seeder {

    public function run() {
        InfoCategory::factory()
            ->count(10)
            ->create();
    }

}
