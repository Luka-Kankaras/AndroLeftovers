<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AnnouncementTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */


    public function testGet(){
        $response = $this->get(route('announcements.index'));
        $response->assertStatus(200);
    }
}
