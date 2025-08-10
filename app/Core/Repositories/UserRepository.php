<?php

namespace App\Core\Repositories;

use App\Core\Models\User;
use App\Core\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @implements UserRepositoryInterface<User>
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function findByPhoneNumber(string $phoneNumber, array $columns = ['*']): User
    {
        return $this->model->select($columns)
            ->where('phone', $phoneNumber)
            ->first();
    }

    public function findByApiToken(string $apiToken, array $columns = ['*']): User
    {
        return $this->model->select($columns)
            ->where('api_token', $apiToken)
            ->first();
    }

    public function getAllIds(): User
    {
        return $this->model->select(['id'])
            ->get();
    }
}
