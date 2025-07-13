<?php

namespace App\Modules\Auth\Repositories\Eloquent;

use App\Core\Repositories\BaseRepository;
use App\Modules\Auth\Repositories\Contracts\BusinessServiceRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BusinessServiceRepository extends BaseRepository implements BusinessServiceRepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function getAllIds(): array
    {
        return $this->model->get()
            ->pluck('id')
            ->toArray();
    }
}
