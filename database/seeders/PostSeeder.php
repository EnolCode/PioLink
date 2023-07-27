<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::create([
            'content' => 'Hola, soy un post y soy del user 1',
            'profile_id' => 1
        ]);

        Post::create([
            'content' => 'Hola, soy un post para probar relaciones y soy del user 1',
            'profile_id' => 1
        ]);

        Post::create([
            'content' => 'Hola, soy un segundo post algo mas largo simplemente para comprobar cosas',
            'profile_id' => 2
        ]);
    }
}
