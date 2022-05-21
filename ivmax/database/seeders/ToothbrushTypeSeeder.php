<?php

namespace Database\Seeders;

use App\Models\ToothbrushType;
use Illuminate\Database\Seeder;

class ToothbrushTypeSeeder extends Seeder {

    protected $names = ['Soft', 'Ultra soft'];

    public function run() {
        foreach ($this->names as $name) {
            ToothbrushType::query()->create([
                'name' => $name
            ]);
        }
    }

}
