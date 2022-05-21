<?php

namespace Database\Seeders;

use App\Models\Post;
use App\Models\Tag;
use App\Models\Team;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder {

    public function run() {

        $faker = Factory::create();

        for ($i = 0; $i < 50; $i++){
            $curr = Post::query()->create([
                "title" => $faker->text(40),
                "text" => $faker->text(2000),
                "thumbnail" => asset('/test-photo.jpg'),
                "active" => $faker->numberBetween(0, 1),
                "user_id" => $faker->numberBetween(1, User::query()->count()),
                "team_id" => $faker->numberBetween(1, Team::query()->count()),
                "time_to_read" => $faker->numberBetween(1, 10),
            ]);

            $this->tag_ids($curr);
        }

    }

    public function tag_ids($post) : void {

        $ids = [];
        $faker = Factory::create();

        for ($i = 0; $i < $faker->numberBetween(3, 6); $i++){
            $id = $faker->numberBetween(1, Tag::query()->count());

            if (!in_array($id, $ids))
                $ids [] = $id;

        }

        $post->tags()->attach($ids);
    }


}
