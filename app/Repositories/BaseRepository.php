<?php

namespace App\Repositories;

use App\Http\Requests\ModelUpdatedRequest;
use App\Http\Requests\UserUpdatedRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;


class BaseRepository
{
    private $model;
    private $relations;
    public function __construct(Model $model, array $relations = [])
    {
        $this->model = $model;
    }

    public function all(): Collection
    {
        return $this->model->get();
    }

    public function getById(int $id): ?Model
    {
        return $this->model->find($id);
    }

    public function save(Model $model): Model
    {
        $model->save();
        return $model;
    }

    public function update(Model $model, UserUpdatedRequest $request): ?Model
    {
        $model->update($request->all());
        return $model;
    }

    public function delete(Model $model): void
    {
        $model->delete();
    }
}
