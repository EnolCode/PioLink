<?php

namespace App\Services;

use App\Exceptions\ModelNotFound\PostNotFoundException;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Post;
use App\Repositories\PostRepository;
use App\Services\BaseService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Psy\Exception\ErrorException;

class PostService implements BaseService
{
    protected $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }
    public function getAll(): Collection
    {
        return $this->postRepository->all();
    }

    public function getById(int $id): ?Post
    {
        $post = $this->postRepository->getById($id);
        if ($post) {
            return $post;
        } else {
            throw new PostNotFoundException($id);
        }
    }

    public function save(PostUpdateRequest $request): ?Post
    {
        $user = Auth::user();
        $postAttributes = $request;
        $postAttributes['profile_id'] = $user->id;
        $post = $this->postRepository->save($postAttributes);
        return $post;
    }

    public function update(int $id, PostUpdateRequest $request): ?Post
    {
        $post = $this->postRepository->getById($id);
        if ($post) {
            return $this->postRepository->update($post, $request);
        } else {
            throw new PostNotFoundException($id);
        }
    }

    public function delete(int $id): void
    {
        $post = $this->postRepository->getById($id);
        if ($post) {
            $this->postRepository->delete($post);
        } else {
            throw new PostNotFoundException($id);
        }
    }
}
