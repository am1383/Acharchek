<?php

namespace App\Modules\Location\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class CityDTO extends DataTransferObject
{
    public ?int $province_id;
}
