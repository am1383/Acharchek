<?php

namespace App\Modules\SMS\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class SendSMSDTO extends DataTransferObject
{
    public string $phone;

    public string $hash_link;
}
