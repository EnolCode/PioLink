<?php

namespace Tests\Unit;

use App\Exceptions\ModelNotFound\EmailNotFoundException;
use App\Exceptions\ModelNotFound\UserNotFoundException;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{

    use RefreshDatabase;
    protected $user1;
    protected $user2;
    protected $profile1;

    public function setUp(): void
    {
        parent::setUp();
        $this->user1 = User::create([
            'email' => 'userTest@gmail.com',
            'password' => bcrypt('hola')
        ]);

        $this->user2 = User::create([
            'email' => 'userTest2@gmail.com',
            'password' => bcrypt('hola')
        ]);
        /**
         *  Profile $profile1
         */
        $this->profile1 = Profile::create([
            'id' => $this->user1->id,
            'user_id' => $this->user1->id
        ]);

        $this->actingAs($this->user1);
    }

    public function test_find_user_by_id(): void
    {
        $response = $this->get("/api/user/id/{$this->user1->id}");

        $response->assertStatus(200);
        $response->assertJson($this->user1->toArray());
        self::assertEquals($response['email'], 'userTest@gmail.com');
    }

    public function test_find_user_for_id_fail_return_exception(): void
    {
        $response = $this->get("/api/user/id/190");
        $response->assertStatus(404)->assertSee("User with ID 190 not found.");
        $this->assertTrue($response->exception instanceof UserNotFoundException);
    }

    public function test_find_user_by_name(): void
    {
        $response = $this->get("/api/user/email/{$this->user2->email}");
        $response->assertStatus(200);
        self::assertEquals($response['email'], 'userTest2@gmail.com');
    }

    public function test_find_user_for_name_fail_return_exception(): void
    {
        $reponse = $this->get("/api/user/email/pacopaquito@fake.com");
        $reponse->assertStatus(404)->assertSee('The user with email: pacopaquito@fake.com doesnt exist.');
        $this->assertTrue($reponse->exception instanceof EmailNotFoundException);
    }

    public function test_findAll_users(): void
    {
        $response = $this->get("/api/users");
        $response->assertStatus(200);
        $responseData = $response->json();
        self::assertCount(2,$responseData);
        $response->assertJsonFragment($this->user2->toArray());
        $response->assertJsonFragment($this->user1->toArray());
    }

    public function test_update_user(): void
    {
        $updateUser = [
           "email" =>"updatedEmail@gmail.com"
        ];
        $response = $this->patch("/api/user/{$this->user1->id}", $updateUser);
        $response->assertStatus(200);
        self::assertEquals($response['email'], 'updatedEmail@gmail.com');
    }

    public function test_delete_user_and_profile_delete(): void
    {
        $response = $this->delete("api/user/{$this->user1->id}");
        $response->assertStatus(200);
        self::assertEquals($response['message'], 'User with id '. $this->user1->id .' deleted successfully.');
        $reponseUserDelete = $this->get("api/user/id/{$this->user1->id}");
        $reponseUserDelete->assertStatus(404);
        $reponseProfileDelete = $this->get("api/profile/{$this->user1->id}");
        $reponseProfileDelete->assertStatus(404);
    }
}
