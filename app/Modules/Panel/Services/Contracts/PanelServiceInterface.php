<?php

namespace App\Modules\Panel\Services\Contracts;

interface PanelServiceInterface
{
    public function getUserPanelInfo(string $apiToken): array;

    public function getUserPanelService(string $apiToken): array;
}
