<?php

namespace App\Modules\Panel\Repositories\Contracts;

use App\Core\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface PanelPackRepositoryInterface extends BaseRepositoryInterface
{
    public function getPanelPacks(): Collection;
}
