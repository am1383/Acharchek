<?php

namespace App\Modules\Auth\Repositories\Eloquent;

use App\Core\Repositories\BaseRepository;
use App\Modules\Auth\Models\Information;
use App\Modules\Auth\Repositories\Contracts\InformationRepositoryInterface;
use Illuminate\Database\Eloquent\Model;

class InformationRepository extends BaseRepository implements InformationRepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function findByUserId(int $userId, array $columns): Information
    {
        return $this->model->select($columns)
            ->where('user_id', $userId)
            ->first();
    }
}
