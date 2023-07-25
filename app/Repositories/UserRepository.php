<?php

namespace App\Repositories;

use App\Http\Requests\UserUpdatedRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;

class UserRepository extends BaseRepository
{
    const RELATIONS = [
        'profile'
    ];
    public function __construct(User $user)
    {
        parent::__construct($user);
    }

    public function all(): Collection
    {
        return $this->model->with(self::RELATIONS)->get();
    }

    public function findUserByUsername(string $name): User|null
    {
        return User::where('name', $name)->first();
    }
}
