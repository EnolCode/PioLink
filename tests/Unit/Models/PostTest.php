<?php

namespace Tests\Unit;

use App\Models\Post;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostTest extends TestCase
{
    use RefreshDatabase;
    protected $user1;
    protected $profile1;
    protected $post;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user1 = User::create([
            'name' => 'test',
            'email' => 'userTest' . time() . '@gmail.com',
            'password' => bcrypt('hola')
        ]);
        // Crea un perfil para asociarlo con el post
        $this->profile1 = Profile::create([
            'id' => 1,
            'user_id' => 1,
        ]);

        // Crea un post y asócialo con el perfil
        $this->post = Post::create([
            'content' => 'Test content',
            'file' => 'test.txt',
            'profile_id' => $this->profile1->id,
        ]);
    }

    public function test_can_create_post()
    {
        // Verifica que el post se haya guardado correctamente en la base de datos
        $this->assertDatabaseHas('posts', [
            'id' => $this->post->id,
            'content' => 'Test content',
            'file' => 'test.txt',
            'profile_id' => $this->profile1->id,
        ]);
    }

    public function test_post_belongs_to_profile()
    {
        // Verifica que puedes acceder al perfil desde el post utilizando la relación `profile`
        $this->assertEquals($this->profile1->id, $this->post->profile->id);
    }

    public function test_post_requires_content()
    {
        // Intenta crear un post sin contenido
        $this->expectException(\Illuminate\Database\QueryException::class);
        Post::create([
            'file' => 'test.txt',
            'profile_id' => 1,
        ]);
    }
}
