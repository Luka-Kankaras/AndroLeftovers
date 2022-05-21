<?php

namespace Database\Factories;

use App\Models\InfoCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class InfoCategoryFactory extends Factory {

    protected $model = InfoCategory::class;

    public function definition() : array {
        return [
            'name' => $this->faker->jobTitle()
        ];
    }

}
