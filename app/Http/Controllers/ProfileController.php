<?php

namespace App\Http\Controllers;

use App\Exceptions\ModelNotFound\ProfileNotFoundException;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function findProfileById(int $id): JsonResponse
    {
        try {
            $profile = Profile::findOrFail($id);
            return response()->json($profile, 200);
        } catch (ModelNotFoundException $e) {
            throw new ProfileNotFoundException($id);
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function findAllProfiles(): JsonResponse
    {
        try{
            $profiles = Profile::all();
            return response()->json($profiles, 200);
        } catch(Exception $e) {
            return abort(404);
        }
    }

    public function updateProfile(int $id, ProfileUpdateRequest $request): JsonResponse
    {
        try{
            $profile = Profile::findOrFail($id);
            $profile->update($request->all());
            return response()->json(['profile' => $profile, 'message' => 'Profile updated successfully'], 200);
        } catch (ModelNotFoundException $e){
            throw new ProfileNotFoundException($id);
        }
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
