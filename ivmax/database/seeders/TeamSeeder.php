<?php

namespace Database\Seeders;

use App\Models\Team;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TeamSeeder extends Seeder {

    public function run() {

        $faker = Factory::create();

        for ($i = 0; $i < 15; $i++)
            Team::query()->create([
                "first_name" => $faker->firstName,
                "last_name" => $faker->lastName,
                "position" => $faker->jobTitle,
                "image" => asset('/test-photo.jpg'),
            ]);
    }

}
