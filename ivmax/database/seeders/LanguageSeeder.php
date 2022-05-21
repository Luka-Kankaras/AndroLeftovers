<?php

namespace Database\Seeders;

use App\Models\Language;
use Illuminate\Database\Seeder;

class LanguageSeeder extends Seeder {

//    protected $countries = ['Default' => 'EN', 'Czech Republic' => 'CZ', 'Croatia' => 'HR', 'Germany' => 'DE', 'United States' => 'US', 'Netherlands' => 'NL'];
//    protected $countries = ['Default' => 'EN', 'Czech Republic' => 'CZ'];
    protected $countries = ['Default' => 'Default'];

    public function run() {
        foreach ($this->countries as $name => $country_code) {
            Language::query()->create([
                'name' => $name,
                'country_code' => $country_code,
            ]);
        }
    }
}
