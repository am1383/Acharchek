<?php

namespace App\Modules\Auth\Repositories\Eloquent;

use App\Core\Repositories\BaseRepository;
use App\Modules\Auth\Repositories\Contracts\MobileDeviceRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class MobileDeviceRepository extends BaseRepository implements MobileDeviceRepositoryInterface
{
    public function __construct(protected Model $model) {}
}
