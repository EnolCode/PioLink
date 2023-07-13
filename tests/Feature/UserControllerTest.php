<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_find_user(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        $response = $this->get("/api/user/{$user->id}");

        $response->assertStatus(200);
        $response->assertJson($user->toArray());
    }

    public function test_findAll_users():void
    {
        // code
    }
}
