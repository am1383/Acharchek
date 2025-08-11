<?php

namespace App\Modules\Panel\Services;

use App\Modules\Panel\Repositories\Contracts\PanelPackRepositoryInterface;
use App\Modules\Panel\Services\Contracts\PanelPackServiceInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PanelPackService implements PanelPackServiceInterface
{
    public function __construct(private PanelPackRepositoryInterface $panelPackRepository) {}

    public function getPanelPacks(): Collection
    {
        return $this->panelPackRepository
            ->get();
    }

    public function getDetailsById(int $id): Model
    {
        return $this->panelPackRepository
            ->findOrFail($id);
    }
}
