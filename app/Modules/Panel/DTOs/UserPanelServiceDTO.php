<?php

namespace App\Modules\Panel\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class UserPanelServiceDTO extends DataTransferObject
{
    public string $api_token;
}
