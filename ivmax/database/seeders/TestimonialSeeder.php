<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Faker\Factory;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder {

    public function run() {

        $faker = Factory::create();

        for ($i = 0; $i < 20; $i++)
            Testimonial::query()->create([
                'first_name' => $faker->firstName,
                'last_name' => $faker->lastName,
                'text' => $faker->text(400),
                'city' => $faker->city,
                'country' => $faker->country,
                "photo" => asset('/test-photo.jpg'),
            ]);

    }

}
