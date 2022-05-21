<?php

namespace Database\Seeders;

use App\Models\Newsletter;
use Faker\Factory;
use Illuminate\Database\Seeder;

class NewsletterSeeder extends Seeder {

    public function run() {

        $faker = Factory::create();

        for ($i = 0;$i < 30; $i++){
            Newsletter::query()->create([
                'email' => $faker->email
            ]);
        }
    }

}
