<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Seeder;
use App\Constants\RoleConstants;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder {

    public function run() {
        User::query()->create([
            'first_name' => 'Super',
            'last_name' => 'Admin',
            'email' => 'admin@ivmax.com',
            'email_verified_at' => now(),
            'password' => bcrypt('iVm@xSA2021'),
        ]);
/*
        User::query()->create([
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@email.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ]);

        User::query()->create([
            'first_name' => 'Blog',
            'last_name' => 'User',
            'email' => 'blogger@email.com',
            'email_verified_at' => now(),
            'password' => bcrypt('12345678'),
        ]);
*/
    }


}
