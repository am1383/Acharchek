<?php

namespace App\Modules\Panel\Repositories\Eloquent;

use App\Core\Repositories\BaseRepository;
use App\Modules\Panel\Repositories\Contracts\PanelPackRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class PanelPackRepository extends BaseRepository implements PanelPackRepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function getPanelPacks(): Collection
    {
        return $this->model->get();
    }
}
