<?php

namespace Database\Seeders;

use App\Models\Faq;
use Faker\Factory;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder {

    public function run() {

        $faker = Factory::create();

        for ($i = 0; $i < 12; $i++){
            $question = $faker->text(40);
            Faq::query()->create([
                'question' => substr($question, 0, strlen($question)-1) . '?',
                'answer' => $faker->text(250),
            ]);
        }

    }

}
