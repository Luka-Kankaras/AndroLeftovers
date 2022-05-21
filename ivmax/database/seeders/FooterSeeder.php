<?php

namespace Database\Seeders;

use App\Models\Footer;
use Illuminate\Database\Seeder;

class FooterSeeder extends Seeder {

    public function run() {
        Footer::query()->create([
            'company_name' => 'ivmax d.o.o.',
            'address' => 'Nikole Tesle 11, 85310 Budva, Montenegro',
            'phone_number' => '+382 33 470 543',
            'terms_and_conditions' => asset('/test.pdf'),
            'privacy_policy' => asset('/test.pdf'),
            'email' => 'info@ivmax.com',
        ]);
    }

}
