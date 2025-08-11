<?php

namespace App\Core\Repositories;

use App\Core\Repositories\Contracts\SettingRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class SettingRepository implements SettingRepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function findByKey(string $key): string
    {
        return $this->model->where('key', $key)
            ->value('value');
    }

    public function updateByKey(string $key, string $value): bool
    {
        return $this->model->where('key', $key)
            ->update(compact('value'));
    }
}
