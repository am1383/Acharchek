<?php

namespace App\Core\Repositories;

use App\Core\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class BaseRepository implements BaseRepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function create(array $attributes): Model
    {
        return $this->model->create($attributes);
    }

    public function get(array $columns = ['*']): Collection
    {
        return $this->model->select($columns)
            ->get();
    }

    public function insert(array $attributes): void
    {
        $this->model->insert($attributes);
    }

    public function updateOrFail(array $attributes): bool
    {
        return $this->model->updateOrFail($attributes);
    }

    public function findOrFail(int $id, array $columns = ['*']): Model
    {
        return $this->model->findOrFail($id, $columns);
    }
}
