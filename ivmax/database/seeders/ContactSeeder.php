<?php

namespace Database\Seeders;

use App\Models\Contact;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder {

    public function run() {

        $faker = Factory::create();

        for ($i = 0; $i < 15; $i++)
            Contact::query()->create([
                'name' => $faker->name,
                'email' => $faker->email,
                'message' => $faker->text(400)
            ]);
    }

}
