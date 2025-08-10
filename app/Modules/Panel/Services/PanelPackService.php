<?php

namespace App\Modules\Panel\Services;

use App\Modules\Panel\Repositories\Contracts\PanelPackRepositoryInterface;
use App\Modules\Panel\Services\Contracts\PanelPackServiceInterface;
use Illuminate\Database\Eloquent\Collection;

class PanelPackService implements PanelPackServiceInterface
{
    public function __construct(private PanelPackRepositoryInterface $panelPackRepository) {}

    public function getPanelPacks(): Collection
    {
        return $this->panelPackRepository
            ->getPanelPacks();
    }

    public function getDetailsById(int $id)
    {
        return $this->panelPackRepository
            ->findOrFail($id);
    }
}
