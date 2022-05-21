<?php

namespace Database\Seeders;

use App\Models\ToothpasteType;
use Illuminate\Database\Seeder;

class ToothpasteTypeSeeder extends Seeder {

    protected $names = ['Iceberg', 'Snowflake'];

    public function run() {
        foreach ($this->names as $name) {
            ToothpasteType::query()->create([
                'name' => $name
            ]);
        }
    }

}
