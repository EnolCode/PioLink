<?php

namespace App\Http\Controllers;

use App\Exceptions\ModelNotFound\ProfileNotFoundException;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use App\Services\ProfileService;
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

    public function updateProfile(int $id, ProfileUpdateRequest $request): JsonResponse
    {
        $profile = $this->profileService->updateProfile($id, $request);
        return response()->json(['profile' => $profile, 'message' => 'Profile updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteProfile(int $id)
    {
        try{
            $profile = Profile::findOrFail($id);
            $profile->delete();
            return response('Profile with id: '.$id.' deleted successfully', 200);
        } catch (ModelNotFoundException $e){
            throw new ProfileNotFoundException($id);
        }
    }
}
