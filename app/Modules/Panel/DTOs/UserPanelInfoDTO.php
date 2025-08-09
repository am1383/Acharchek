<?php

namespace App\Modules\Panel\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class UserPanelInfoDTO extends DataTransferObject
{
    public string $api_token;
}
