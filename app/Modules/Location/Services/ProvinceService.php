<?php

namespace App\Modules\Location\Services;

use App\Core\Models\Province;
use App\Modules\Auth\Repositories\Contracts\ProvinceRepositoryInterface;
use App\Modules\Location\Services\Contracts\ProvinceServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class ProvinceService implements ProvinceServiceInterface
{
    public function __construct(private ProvinceRepositoryInterface $provinceRepository) {}

    public function getProvinces(): Collection
    {
        return $this->provinceRepository
            ->get();
    }

    public function getProvinceDetails(int $id): Province
    {
        return $this->provinceRepository
            ->findOrFail($id);
    }
}
