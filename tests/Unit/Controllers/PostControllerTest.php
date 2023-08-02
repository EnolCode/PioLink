<?php

namespace Tests\Unit;

use App\Exceptions\ModelNotFound\PostNotFoundException;
use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostControllerTest extends TestCase
{

    use RefreshDatabase;
    protected $user1;
    protected $post2;
    protected $post1;
    protected $profile1;

    public function setUp(): void
    {
        parent::setUp();
        $this->user1 = User::create([
            'name' => 'test',
            'email' => 'postTest' . time() . '@gmail.com',
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

        $this->post1 = Post::create([
            'content' => 'Mucho post hay loquin',
            'file' => 'Pues una foto cualquiera',
            'profile_id' => $this->profile1->id,
        ]);

        $this->post2 = Post::create([
            'content' => 'Mucho post hay loquin 2',
            'file' => 'Pues una foto cualquiera 2',
            'profile_id' => 1,
        ]);

        $this->actingAs($this->user1);
    }

    public function test_find_post_by_id(): void
    {
        $response = $this->get("/api/post/{$this->post1->id}");
        $response->assertStatus(200);
        $response->assertJson($this->post1->toArray());
        self::assertEquals($response['content'], 'Mucho post hay loquin');
    }

    public function test_find_post_for_id_fail_return_exception(): void
    {
        $response = $this->get("/api/post/190");
        $response->assertStatus(404)->assertSee("Post with ID 190 not found.");
        $this->assertTrue($response->exception instanceof PostNotFoundException);
    }

    public function test_findAll_posts(): void
    {
        $response = $this->get("/api/posts");
        $response->assertStatus(200);
        $responseData = $response->json();
        self::assertCount(2,$responseData);
        $response->assertJsonFragment($this->post2->toArray());
        $response->assertJsonFragment($this->post1->toArray());
    }

    public function test_update_post(): void
    {
        $updatepost = [
           "content" => "Post 1 updaate",
           "file" =>"Otra foto actualizada"
        ];
        $response = $this->patch("/api/post/{$this->post1->id}", $updatepost);
        $response->assertStatus(200);
        self::assertEquals($response['content'], 'Post 1 updaate');
        self::assertEquals($response['file'], 'Otra foto actualizada');
    }

    public function test_delete_post_and_profile_delete(): void
    {
        $response = $this->delete("api/post/{$this->post1->id}");
        $response->assertStatus(200);
        self::assertEquals($response['message'], 'Post with id '. $this->post1->id .' deleted successfully.');
        $reponsepostDelete = $this->get("api/post/id/{$this->post1->id}");
        $reponsepostDelete->assertStatus(404);
    }
}
