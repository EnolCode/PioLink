<?php

namespace App\Repositories;

use App\Http\Requests\ModelUpdatedRequest;
use App\Http\Requests\UserUpdatedRequest;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Client\Request;

class BaseRepository
{
    protected $model;
    private $relations;
    public function __construct(Model $model, array $relations = [])
    {

        $this->model = $model;
        $this->relations = $relations;
    }

    public function all(): Collection
    {
        $query = $this->model;
        if(!empty($this->relations)){
            $query = $query->with($this->relations);
        }
        return $query->get();
    }

    public function getById(int $id): ?Model
    {
        $query = $this->model;
        if(!empty($this->relations)){
            $query = $query->with($this->relations);
        }
        return $query->find($id);
    }

    public function save(Model $model): Model
    {
        $model->save();
        return $model;
    }

    public function update(Model $model, $request): ?Model
    {
        $model->update($request->all());
        return $model;
    }

    public function delete(Model $model): void
    {
        $model->delete();
    }
}
