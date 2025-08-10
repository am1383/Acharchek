<?php

namespace App\Modules\Auth\Repositories\Eloquent;

use App\Core\Repositories\BaseRepository;
use App\Modules\Auth\Repositories\Contracts\ProvinceRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ProvinceRepository extends BaseRepository implements ProvinceRepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function getProvinces(): Collection
    {
        return $this->model->get();
    }
}
