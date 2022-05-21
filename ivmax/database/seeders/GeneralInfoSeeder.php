<?php

namespace Database\Seeders;

use App\Models\GeneralInfo;
use App\Models\InfoCategory;
use Faker\Factory;
use Illuminate\Database\Seeder;

class GeneralInfoSeeder extends Seeder {

    public function run() {

        $faker = Factory::create();

        for ($i = 0; $i < 15; $i++)
            GeneralInfo::query()->create([
                'name' => ucfirst($faker->word),
                'description' => $faker->text(300),
                'video' => 'https://file-examples-com.github.io/uploads/2017/04/file_example_MP4_480_1_5MG.mp4',
                'video_name' => 'test_video.mp4',
                'video_ext' => 'mp4',
                'info_category_id' => $faker->numberBetween(1, InfoCategory::query()->count())
            ]);

    }

}
