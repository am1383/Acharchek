<?php

namespace App\Core\Repositories;

use App\Core\Models\LoginTries;
use App\Core\Repositories\Contracts\LoginTriesRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class LoginTriesRepository extends BaseRepository implements LoginTriesRepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function findByPhoneNumberOrFail(string $phoneNumber, array $columns = ['*']): LoginTries
    {
        return $this->model->select($columns)
            ->where('is_customer', 0)
            ->where('phone', $phoneNumber)
            ->where('finished', 0)
            ->firstOrFail();
    }

    public function updateOrFailById(int $Id, array $attributes): void
    {
        $this->model->where('id', $Id)
            ->updateOrFail($attributes);
    }
}
