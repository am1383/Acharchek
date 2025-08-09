<?php

namespace App\Modules\Panel\Http\Controllers;

use App\Modules\Admin\Services\Contracts\PanelServiceInterface;
use App\Modules\Panel\DTOs\UserPanelInfoDTO;
use App\Modules\Panel\DTOs\UserPanelServiceDTO;
use App\Modules\Panel\Requests\UserPanelInfoRequest;
use App\Modules\Panel\Requests\UserPanelServiceRequest;
use App\Modules\Panel\Resources\UserPanelInfoResource;
use App\Modules\Panel\Resources\UserPanelServiceResource;

class PanelController
{
    public function __construct(private PanelServiceInterface $panelService) {}

    public function userPanelInfo(UserPanelInfoRequest $request): UserPanelInfoResource
    {
        $userPanelInfoDTO = new UserPanelInfoDTO($request->validated());

        return new UserPanelInfoResource($this->panelService
            ->getUserPanelInfo($userPanelInfoDTO->api_token));

    }

    public function userPanelService(UserPanelServiceRequest $request): UserPanelServiceResource
    {
        $userPanelServiceDTO = new UserPanelServiceDTO($request->validated());

        return new UserPanelServiceResource($this->panelService
            ->getUserPanelService($userPanelServiceDTO->api_token));
    }
}
