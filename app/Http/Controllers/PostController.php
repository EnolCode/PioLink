<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostUpdateRequest;
use App\Http\Resources\PostResource;
use App\Services\PostService;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class PostController extends Controller
{

    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function findPostById(int $id): JsonResponse
    {
        $post = $this->postService->getById($id);
        return response()->json(new PostResource($post), 200);
    }

    public function getAll(): AnonymousResourceCollection
    {
        $posts = $this->postService->getAll();
        return PostResource::collection($posts);
    }

    public function update(int $id, PostUpdateRequest $request): JsonResponse
    {
        $post = $this->postService->update($id, $request);
        return response()->json($post, 200);
    }

    public function save(PostUpdateRequest $request): JsonResponse
    {
        $post = $this->postService->save($request);
        return response()->json($post, 201);
    }

    public function delete(int $id): JsonResponse
    {
        $this->postService->delete($id);
        return response()->json(['message' => 'Post with id '.$id. ' deleted successfully.']);
    }
}
