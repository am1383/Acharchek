<?php

namespace App\Modules\Auth\Repositories\Eloquent;

use App\Core\Repositories\BaseRepository;
use App\Modules\Auth\Repositories\Contracts\BusinessRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class BusinessRepository extends BaseRepository implements BusinessRepositoryInterface
{
    public function __construct(protected Model $model) {}
}
