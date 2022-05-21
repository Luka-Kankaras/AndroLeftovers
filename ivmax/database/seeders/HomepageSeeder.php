<?php

namespace Database\Seeders;

use App\Models\Homepage;
use Faker\Factory;
use Illuminate\Database\Seeder;

class HomepageSeeder extends Seeder {

    public function run() {

        Homepage::query()->create([
            'title' => 'Spoil yourself with necessity',
            'subtitle' => 'Toothbrush. Toothpaste. All in one',
            'text_1' => 'Welcome to the new age of oral hygiene, in a unique way.',
            'text_2' => 'Give yourself the treatment you deserve',
            'photo_or_video' => 'https://file-examples-com.github.io/uploads/2017/04/file_example_MP4_480_1_5MG.mp4',
            'video_name' => 'test_video.mp4',
            'video_ext' => 'mp4',
            'thumbnail_big' => asset('/test-photo.jpg'),
            'thumbnail_small' => asset('/test-photo.jpg'),
            'ivmax_anatomy' => "The ivmax toothbrush is ergonomically designed, and made of magnesium and zinc alloy that ensures the longevity of the product. The toothbrush doesn't contain batteries or any other technical elements that can cause malfunctions.",
            'feature_1' => "There are often times where we can't maintain oral and dental hygiene in the way we are used to. Thanks to the ivmax, you can now brush your teeth at any time, anywhere!",
            'feature_2' => "The body of the ivmax toothbrush is made of antibacterial metal. During the manufacturing process of the toothbrush, medical-grade polymers were used to ensure safe outdoor use.",
            'feature_3' => "ivmax® is a product developed in collaboration with the famous gIDE Institute from the USA. Together, we've collaborated to create a toothbrush that provides convenience like no other.",
            'feature_4' => "The amount of toothpaste in our cartridges is below the maximum amount of liquid that is allowed to be brought onto planes. Now, you can take care of your oral hygiene anywhere you go.",
            'annual_text_1' => "Subscribe to an annual plan and get Ivmax refills every 3 months.",
            'annual_text_2' => "You can even choose a new toothbrush and toothpaste each time!",
        ]);

    }

}
