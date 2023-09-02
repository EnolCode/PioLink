<?php

namespace App\Repositories;

use App\Models\Profile;

class ProfileRepository extends BaseRepository
{

    public function __construct(Profile $profile)
    {
        parent::__construct($profile);
    }

    public function uploadAvatarImage(Profile $profile, string $fileName): Profile
    {
        $profile->avatarImage = $fileName;
        $profile->save();
        return $profile;
    }
}
