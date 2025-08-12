<?php

namespace App\Modules\Location\Http\Controllers;

use App\Modules\Location\DTOs\CityDetailsDTO;
use App\Modules\Location\DTOs\CityDTO;
use App\Modules\Location\Requests\CityDetailsRequest;
use App\Modules\Location\Requests\CityRequest;
use App\Modules\Location\Resources\CityDetailsResource;
use App\Modules\Location\Resources\CityResource;
use App\Modules\Location\Services\Contracts\CityServiceInterface;

class CityController
{
    public function __construct(private CityServiceInterface $cityService) {}

    public function show(CityRequest $request): CityResource
    {
        $dto = new CityDTO($request->validated());

        return new CityResource($this->cityService
            ->getCities($dto->province_id));
    }

    public function details(CityDetailsRequest $request): CityDetailsResource
    {
        $dto = new CityDetailsDTO($request->validated());

        return new CityDetailsResource($this->cityService
            ->getCityDetailsById($dto->id));
    }
}
