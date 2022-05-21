<?php

namespace Database\Seeders;

use App\Models\Color;
use Illuminate\Database\Seeder;

class ColorSeeder extends Seeder {

    private $colors = [
        'Silver' => '#c7c7c7',
        'Azure' => '#70b7f8',
        'Royal' => '#de92d6',
        'Gold Rose' => '#fee9dc',
        'Black' => '#000000',
        'White' => '#ffffff',
    ];

    public function run() {

        foreach ($this->colors as $color => $hex)
            Color::query()->create([
                'name' => $color,
                'hex' => $hex,
            ]);

    }

}
