<?php

namespace App\Modules\Auth\Repositories\Eloquent;

use App\Core\Repositories\BaseRepository;
use App\Modules\Auth\Models\User;
use App\Modules\Auth\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

/**
 * @implements UserRepositoryInterface<User>
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function findByPhoneNumber(string $phoneNumber): User
    {
        return $this->model->where('phone', $phoneNumber)
            ->first();
    }
}
