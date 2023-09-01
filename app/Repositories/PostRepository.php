<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository extends BaseRepository
{
    const RELATIONS = [
        'profile'
    ];
    public function __construct(Post $post)
    {
        parent::__construct($post, self::RELATIONS);
    }
}
