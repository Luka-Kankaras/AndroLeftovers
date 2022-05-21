<?php

namespace Database\Seeders;

use App\Models\Company;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Faker\Factory;

class CompanySeeder extends Seeder {

    public function run() {
        $faker = Factory::create();

        Company::query()->create([
            'section_1' => $faker->text,
            'section_1_bold' => $faker->text,
            'section_2' => $faker->text,
            "photo_1" => asset('/test-photo.jpg'),
            "photo_2" => asset('/test-photo.jpg'),
        ]);
    }

}
