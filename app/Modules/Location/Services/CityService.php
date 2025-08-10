<?php

namespace App\Modules\Location\Services;

use App\Modules\Auth\Models\City;
use App\Modules\Auth\Repositories\Contracts\CityRepositoryInterface;
use App\Modules\Location\Services\Contracts\CityServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class CityService implements CityServiceInterface
{
    public function __construct(private CityRepositoryInterface $cityRepository) {}

    public function getCities(int $provinceId): Collection
    {
        return $this->cityRepository->getCities($provinceId);
    }

    public function getCityDetailsById(int $id): City
    {
        return $this->cityRepository->findOrFail($id);
    }
}
