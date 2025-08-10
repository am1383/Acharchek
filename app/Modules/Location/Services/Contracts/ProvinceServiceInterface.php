<?php

namespace App\Modules\Location\Services\Contracts;

use App\Modules\Auth\Models\Province;
use Illuminate\Database\Eloquent\Collection;

interface ProvinceServiceInterface
{
    public function getProvinces(): Collection;

    public function getProvinceDetails(int $id): Province;
}
