<?php

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            "title" => $this->faker->text(40),
            "text" => $this->faker->text(2000),
            "thumbnail" => asset('/test-photo.jpg'),
            "active" => $this->faker->numberBetween(0,1),
            "user_id" => $this->faker->numberBetween(1,3),
            "time_to_read" => $this->faker->numberBetween(1, 10),
        ];
    }
}
