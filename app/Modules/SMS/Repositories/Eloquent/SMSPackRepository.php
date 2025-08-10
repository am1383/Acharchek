<?php

namespace App\Modules\SMS\Repositories\Eloquent;

use App\Core\Repositories\BaseRepository;
use App\Modules\SMS\Repositories\Contracts\SMSPackRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class SMSPackRepository extends BaseRepository implements SMSPackRepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function getSMSPacks(): Collection
    {
        return $this->model->get();
    }
}
