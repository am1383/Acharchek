<?php

namespace App\Modules\Customer\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class TryEnterDTO extends DataTransferObject
{
    public string $phone;

    public string $hash_link;
}
