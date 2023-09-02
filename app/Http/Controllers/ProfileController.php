<?php

namespace App\Http\Controllers;

use App\Exceptions\ModelNotFound\ProfileNotFoundException;
use App\Http\Requests\AvatarImageRequest;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use App\Services\ProfileService;
use Error;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $profileService;

    public function __construct(ProfileService $profileService)
    {
        $this->profileService = $profileService;
    }

    public function findProfileById(int $id): JsonResponse
    {
        $profile =  $this->profileService->getById($id);
        return response()->json($profile, 200);
    }

    public function findAllProfiles(): Collection
    {
        return $this->profileService->getAll();
    }

    public function update(int $id, ProfileUpdateRequest $request): JsonResponse
    {
        $profile = $this->profileService->update($id, $request);
        return response()->json($profile, 200);
    }

    public function delete(int $id)
    {
        $this->profileService->delete($id);
        return response()->json(['message' =>'Profile with id '.$id .' deleted successfully.'], 200);
    }

    public function uploadAvatarImage(AvatarImageRequest $request): JsonResponse
    {
            $profile = $this->profileService->storeAvatarImage($request);
            return response()->json($profile, 201);
    }
}
