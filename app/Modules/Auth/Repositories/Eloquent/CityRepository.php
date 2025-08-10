<?php

namespace App\Modules\Auth\Repositories\Eloquent;

use App\Core\Repositories\BaseRepository;
use App\Modules\Auth\Models\City;
use App\Modules\Auth\Repositories\Contracts\CityRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class CityRepository extends BaseRepository implements CityRepositoryInterface
{
    public function __construct(protected Model $model) {}

    public function findOrFailById(int $cityId, int $provinceId, array $columns): City
    {
        return $this->model->where('id', $cityId)
            ->where('province_id', $provinceId)
            ->firstOrFail($columns);
    }

    public function getCities(?int $provinceId): Collection
    {
        return $this->model
            ->when($provinceId, fn ($query) => $query
                ->where('province_id', $provinceId))
            ->get();
    }
}
