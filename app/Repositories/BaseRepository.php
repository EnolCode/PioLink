<?php

namespace App\Repositories;

use App\Http\Requests\ModelUpdatedRequest;
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

    public function getById(int $id): Model|null
    {
        return $this->model->find($id);
    }

    public function save(Model $model)
    {
        $model->save();
        return $model;
    }

    public function update(int $id, array $request): Model|null
    {
        $model = $this->model->findOrFail($id);
        $model->update($request);
        return $model;
    }

    public function delete(int $id): Model|null
    {
        $model = $this->model->findOrFail($id);
        $model->delete();
        return $model;
    }
}
