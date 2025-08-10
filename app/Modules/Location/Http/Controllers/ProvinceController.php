<?php

namespace App\Modules\Location\Http\Controllers;

use App\Modules\Location\DTOs\ProvinceDetailsDTO;
use App\Modules\Location\Requests\ProvinceDetailsRequest;
use App\Modules\Location\Services\Contracts\ProvinceServiceInterface;
use App\Modules\Loction\Resources\ProvinceResource;

class ProvinceController
{
    public function __construct(private ProvinceServiceInterface $provinceService) {}

    public function show(): ProvinceResource
    {
        return new ProvinceResource($this->provinceService
            ->getProvinces());
    }

    public function details(ProvinceDetailsRequest $request): ProvinceResource
    {
        $provinceDetailsDTO = new ProvinceDetailsDTO($request->validated());

        return new ProvinceResource($this->provinceService
            ->getProvinceDetails($provinceDetailsDTO->id));
    }
}
