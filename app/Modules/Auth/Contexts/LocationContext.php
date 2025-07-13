<?php

namespace App\Modules\Auth\Contexts;

use App\Modules\Auth\Repositories\Contracts\CityRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\ProvinceRepositoryInterface;

class LocationContext
{
    public function __construct(
        public readonly CityRepositoryInterface $cityRepository,
        public readonly ProvinceRepositoryInterface $provinceRepository,
    ) {}
}
