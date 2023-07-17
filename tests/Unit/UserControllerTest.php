<?php

namespace Tests\Feature;

use App\Exceptions\UserNameNotFoundException;
use App\Exceptions\UserNotFoundException;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    use RefreshDatabase;
    protected $user1;
    protected $user2;

    public function setUp(): void
    {
        parent::setUp();
        $this->user1 = User::create([
            'name' => 'test',
            'email' => 'userTest' . time() . '@gmail.com',
            'password' => bcrypt('hola')
        ]);

        $this->user2 = User::create([
            'name' => 'test2',
            'email' => 'userTest2@gmail.com',
            'password' => bcrypt('hola')
        ]);

        $this->actingAs($this->user1);
    }

    public function test_find_user_by_id(): void
    {
        $response = $this->get("/api/user/id/{$this->user1->id}");

        $response->assertStatus(200);
        $response->assertJson($this->user1->toArray());
        self::assertEquals($response['name'], 'test');
    }

    public function test_find_user_for_id_fail_return_exception(): void
    {
        $response = $this->get("/api/user/id/190");
        $response->assertStatus(404)->assertSee("User with ID 190 not found.");
        $this->assertTrue($response->exception instanceof UserNotFoundException);
    }

    public function test_find_user_by_name(): void
    {
        $response = $this->get("/api/user/name/{$this->user2->name}");
        $response->assertStatus(200);
        self::assertEquals($response['name'], 'test2');
        self::assertEquals($response['email'], 'userTest2@gmail.com');
    }

    public function test_find_user_for_name_fail_return_exception(): void
    {
        $reponse = $this->get("/api/user/name/pacopaquito");
        $reponse->assertStatus(404)->assertSee('The user: pacopaquito doesnt exist.');
        $this->assertTrue($reponse->exception instanceof UserNameNotFoundException);
    }

    public function test_findAll_users(): void
    {
        $response = $this->get("/api/users");
        $response->assertStatus(200);
        $responseData = $response->json();
        self::assertCount(2,$responseData);
        $response->assertJson([$this->user1->toArray()]);
    }

    public function test_update_user(): void
    {
        $newUser = [
           "name" => "test1 updated",
           "email" =>"updatedEmail@gmail.com"
        ];
        $response = $this->put("/api/user/{$this->user1->id}", $newUser);
        $response->assertStatus(200);
        self::assertEquals($response['name'], 'test1 updated');
        self::assertEquals($response['email'], 'updatedEmail@gmail.com');
    }

    public function test_delete_user(): void
    {
        $response = $this->delete("api/user/{$this->user1->id}");
        $response->assertStatus(200);
        $response->assertContent('User with id '. $this->user1->id .' deleted successfully.');
        $reponseUserDelete = $this->get("api/user/id/{$this->user1->id}");
        $reponseUserDelete->assertStatus(404);
    }
}
