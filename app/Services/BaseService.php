<?php

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

interface BaseService
{
    public function getAll(): Collection;

    public function getById(int $id): ?Model;

    public function delete(int $id): void;
}
