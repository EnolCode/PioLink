<?php

namespace App\Services;

use App\Exceptions\ModelNotFound\ProfileNotFoundException;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Profile;
use App\Repositories\ProfileRepository;
use Illuminate\Database\Eloquent\Collection;

class ProfileService
{
    protected $profileRepository;

    public function __construct(ProfileRepository $profileRepository)
    {
        $this->profileRepository = $profileRepository;
    }

    public function getAll(): Collection
    {
        return $this->profileRepository->all();
    }

    public function getById(int $id): ?Profile
    {
        $profile = $this->profileRepository->getById($id);
        if($profile){
            return $profile;
        } else{
            throw new ProfileNotFoundException($id);
        }
    }

    public function updateProfile(int $id, ProfileUpdateRequest $request): ?Profile
    {
        $profile = $this->profileRepository->getById($id);
        if($profile) {
            return $this->profileRepository->update($profile, $request);
        } else{
            throw new ProfileNotFoundException($id);
        }
    }

    public function deleteProfile(int $id): void
    {
        $profile = $this->profileRepository->getById($id);
        if($profile){
            $this->profileRepository->delete($profile->id);
        } else{
            throw new ProfileNotFoundException($id);
        }
    }
}
