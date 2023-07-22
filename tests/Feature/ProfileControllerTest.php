<?php

namespace Tests\Feature;

use App\Exceptions\ModelNotFound\ProfileNotFoundException;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */

    use RefreshDatabase;
    protected $profile1;
    protected $user1;
    protected $profile2;
    public function setUp(): void
    {
        parent::setUp();
        $this->user1 = User::create([
            'name' => 'test',
            'email' => 'userTest' . time() . '@gmail.com',
            'password' => bcrypt('hola')
        ]);
        $this->profile1 = Profile::create([
            'id' => $this->user1->id,
            'name' => "Prueba name",
            'lastname' => 'prueba lastname',
            'location' => 'prueba location',
            'age' => 5,
            'isBanned' => false,
            'longDescription' => 'Mucho texto',
            'shortDescription' => 'Poco texto',
            'linkedin' => 'www.linkedin.com',
            'avatarImage' => 'avatarIMG',
            'backgroundImage' => 'randomeImage.pjp',
            'user_id' => $this->user1->id
        ]);

        $this->profile2 = Profile::create([
            'id' => 2,
            'name' => "Prueba name2",
            'lastname' => 'prueba lastname2',
            'location' => 'prueba location2',
            'age' => 5,
            'isBanned' => false,
            'longDescription' => 'Mucho texto2',
            'shortDescription' => 'Poco texto2',
            'linkedin' => 'www.linkedin.com2',
            'avatarImage' => 'avatarIMG2',
            'backgroundImage' => 'randomeImage.pjp2',
            'user_id' => $this->user1->id
        ]);
        $this->actingAs($this->user1);
    }

    public function test_find_profile_by_id_returns_profile_with_expected_id(): void
    {
        $response = $this->get("/api/profile/{$this->profile1->id}");
        $response->assertStatus(200);
        $response->assertJson($this->profile1->toArray());
        self::assertEquals($response['name'], 'Prueba name');
        self::assertEquals($response['user_id'], 1);
    }

    public function test_find_profile_by_id_returns_exception_when_id_dont_exist(): void
    {
        $response = $this->get("api/profile/5");
        $response->assertStatus(404)->assertSee("Profile with ID 5 not found.");
        $this->assertTrue($response->exception instanceof ProfileNotFoundException);
    }

    public function test_return_all_profiles(): void
    {
        $response = $this->get("api/profiles");
        $response->assertStatus(200);
        $responseData = $response->json();
        self::assertCount(2, $responseData);
        $response->assertJsonFragment($this->profile2->toArray());
        $response->assertJsonFragment($this->profile1->toArray());
    }

    public function test_updated_profile_by_id(): void
    {
        $updateProfile = [
            "name" => "test update",
            "shortDescription" => "test update",
            "avatarImage" => "image update"
        ];

        $response = $this->put("/api/profile/edit/{$this->profile1->id}", $updateProfile);
        $response->assertStatus(200);
        $responseData = $response->json('profile');
        self::assertEquals($responseData['name'], 'test update');
        self::assertEquals($responseData['shortDescription'], 'test update');
        self::assertEquals($responseData['avatarImage'], 'image update');
    }

    public function test_deleted_profile_by_id(): void
    {
        $response = $this->delete("api/profile/{$this->profile2->id}");
        $response->assertStatus(200);
        $response->assertSee("Profile with id: 2 deleted successfully");
        $reponseProfileDelete = $this->get("api/profile/id/{$this->profile2->id}");
        $reponseProfileDelete->assertStatus(404);
    }

    public function test_deleted_profile_by_id_return_exception_when_id_dont_exist(): void
    {
        $response = $this->delete("api/profile/5");
        $response->assertStatus(404)->assertSee("Profile with ID 5 not found.");
        $this->assertTrue($response->exception instanceof ProfileNotFoundException);
    }
}
