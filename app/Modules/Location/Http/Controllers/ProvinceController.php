<?php

namespace App\Modules\Location\Http\Controllers;

use App\Modules\Location\DTOs\ProvinceDetailsDTO;
use App\Modules\Location\Requests\ProvinceDetailsRequest;
use App\Modules\Location\Resources\ProvinceDetailsResource;
use App\Modules\Location\Resources\ProvinceResource;
use App\Modules\Location\Services\Contracts\ProvinceServiceInterface;

class ProvinceController
{
    public function __construct(private ProvinceServiceInterface $provinceService) {}

    public function show(): ProvinceResource
    {
        return new ProvinceResource($this->provinceService
            ->getProvinces());
    }

    public function details(ProvinceDetailsRequest $request): ProvinceDetailsResource
    {
        $dto = new ProvinceDetailsDTO($request->validated());

        return new ProvinceDetailsResource($this->provinceService
            ->getProvinceDetails($dto->id));
    }
}
