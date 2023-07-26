<?php

namespace App\Repositories;

use App\Http\Requests\UserUpdatedRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository
{
    const RELATIONS = [
        'profile'
    ];
    public function __construct(User $user)
    {
        parent::__construct($user, self::RELATIONS);
    }

    public function findUserByUsername(string $name): User|null
    {
        return User::where('name', $name)->first();
    }

    public function delete(Model $model): void
    {
        $model->profile->delete();
        $model->delete();
    }
}
