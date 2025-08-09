<?php

namespace App\Modules\Admin\Services\Contracts;

interface PanelServiceInterface
{
    public function getUserPanelInfo(string $apiToken): array;

    public function getUserPanelService(string $apiToken): array;
}
