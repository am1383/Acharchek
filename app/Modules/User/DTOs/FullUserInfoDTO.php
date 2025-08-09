<?php

namespace App\Modules\User\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class FullUserInfoDTO extends DataTransferObject
{
    public string $api_token;
}
