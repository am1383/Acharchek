<?php

namespace App\Modules\SMS\Repositories\Contracts;

use App\Core\Repositories\Contracts\BaseRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

interface SMSPackRepositoryInterface extends BaseRepositoryInterface
{
    public function getSMSPacks(): Collection;
}
