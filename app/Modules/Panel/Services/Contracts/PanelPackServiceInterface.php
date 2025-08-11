<?php

namespace App\Modules\Panel\Services\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface PanelPackServiceInterface
{
    public function getPanelPacks(): Collection;

    public function getDetailsById(int $id): Model;
}
