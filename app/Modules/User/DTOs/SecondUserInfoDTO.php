<?php

namespace App\Modules\User\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class SecondUserInfoDTO extends DataTransferObject
{
    public string $api_token;
}
