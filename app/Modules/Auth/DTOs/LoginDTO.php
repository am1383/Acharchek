<?php

namespace App\Modules\Auth\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class LoginDTO extends DataTransferObject
{
    public string $phone;

    public string $verify_code;

    public string $device_info;
}
