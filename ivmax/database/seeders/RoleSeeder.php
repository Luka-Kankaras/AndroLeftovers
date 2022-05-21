<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder {

    private $roles = ['super admin', 'admin'];

    public function run() {
        foreach ($this->roles as $role)
            Role::query()->create([
                'name' => $role
            ]);
    }

}
