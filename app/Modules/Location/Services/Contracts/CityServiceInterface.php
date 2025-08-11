<?php

namespace App\Modules\Location\Services\Contracts;

use App\Core\Models\City;
use Illuminate\Database\Eloquent\Collection;

interface CityServiceInterface
{
    public function getCities(int $provinceId): Collection;

    public function getCityDetailsById(int $id): City;
}
