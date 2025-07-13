<?php

namespace App\Modules\Auth\Repositories\Contracts;

use App\Core\Repositories\Contracts\BaseRepositoryInterface;
use App\Modules\Auth\Models\City;

interface CityRepositoryInterface extends BaseRepositoryInterface
{
    public function findOrFailById(int $cityId, int $provinceId, array $columns): City;
}
