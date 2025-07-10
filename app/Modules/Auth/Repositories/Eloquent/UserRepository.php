<?php

namespace App\Modules\Auth\Repositories\Eloquent;

use App\Modules\Auth\Models\User;
use App\Modules\Auth\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private Model $model) {}

    public function findByPhoneNumber(string $phoneNumber): User
    {
        return $this->model->where('phone', $phoneNumber)
            ->first();
    }
}
