<?php

namespace App\Modules\Customer\Repositories;

use App\Core\Repositories\BaseRepository;
use App\Modules\Customer\Models\CustomerSecret;
use App\Modules\Customer\Repositories\Contracts\CustomerSecretRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class CustomerSecretRepository extends BaseRepository implements CustomerSecretRepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function findByPhoneNumberOrFail(string $phoneNumber, array $columns): CustomerSecret
    {
        return $this->model->select($columns)
            ->where('phone_customer', $phoneNumber)
            ->firstOrFail();
    }

    public function findOrFailByCustomerSecret(string $customerSecret, array $columns = ['*']): CustomerSecret
    {
        return $this->model->select($columns)
            ->where('secret', $customerSecret)
            ->firstOrFail();
    }
}
