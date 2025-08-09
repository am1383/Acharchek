<?php

namespace App\Modules\Auth\Repositories\Eloquent;

use App\Core\Repositories\BaseRepository;
use App\Core\Repositories\Contracts\UserRepositoryInterface;
use App\Modules\Auth\Models\User;
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
