<?php

namespace App\Modules\Panel\Http\Controllers;

use App\Modules\Location\DTOs\CityDetailsDTO;
use App\Modules\Location\DTOs\CityDTO;
use App\Modules\Location\Requests\CityDetailsRequest;
use App\Modules\Location\Requests\CityRequest;
use App\Modules\Location\Services\Contracts\CityServiceInterface;
use App\Modules\Loction\Resources\CityDetailsResource;
use App\Modules\Loction\Resources\CityResource;

class CityController
{
    public function __construct(private CityServiceInterface $cityService) {}

    public function show(CityRequest $request): CityResource
    {
        $cityDTO = new CityDTO($request->validated());

        return new CityResource($this->cityService
            ->getCities($cityDTO->province_id));
    }

    public function details(CityDetailsRequest $request): CityDetailsResource
    {
        $cityDetailsDTO = new CityDetailsDTO($request->validated());

        return new CityDetailsResource($this->cityService
            ->getCityDetailsById($cityDetailsDTO->id));
    }
}
