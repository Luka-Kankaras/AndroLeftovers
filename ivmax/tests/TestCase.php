<?php

namespace Tests;

use App\Models\Role;
use App\Models\User;
use Database\Seeders\RoleSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(RoleSeeder::class);
    }

    protected function signIn($user = null)
    {
        return $this->actingAs($user ?? User::factory()->create());
    }

    protected function signInAdmin($user = null)
    {
        return $this->actingAs($user ?? User::factory()->create()->assignRole('admin'));
    }
}
