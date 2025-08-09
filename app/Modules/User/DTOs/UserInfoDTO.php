<?php

namespace App\Modules\User\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class UserInfoDTO extends DataTransferObject
{
    public string $api_token;
}
