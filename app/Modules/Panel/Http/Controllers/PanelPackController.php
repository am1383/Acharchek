<?php

namespace App\Modules\Panel\Http\Controllers;

use App\Modules\Panel\DTOs\PanelPackDetailsDTO;
use App\Modules\Panel\Requests\PanelPackDetailsRequest;
use App\Modules\Panel\Resources\PanelPackDetailsResource;
use App\Modules\Panel\Resources\PanelPackResource;
use App\Modules\Panel\Services\PanelPackService;

class PanelPackController
{
    public function __construct(private PanelPackService $panelPackService) {}

    public function show(): PanelPackResource
    {
        return new PanelPackResource($this->panelPackService
            ->getPanelPacks());
    }

    public function details(PanelPackDetailsRequest $request): PanelPackDetailsResource
    {
        $dto = new PanelPackDetailsDTO($request->validated());

        return new PanelPackDetailsResource($this->panelPackService
            ->getDetailsById($dto->id));
    }
}
