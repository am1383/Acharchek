<?php

namespace App\Core\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
interface BaseRepositoryInterface
{
    /**
     * @return TModel
     */
    public function create(array $attributes): Model;

    public function get(array $columns = ['*']): Collection;

    public function insert(array $attributes): void;

    public function updateOrFail(array $attributes): bool;

    public function findOrFail(int $id, array $columns = ['*']): Model;
}
