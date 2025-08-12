<?php

namespace App\Modules\Customer\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class FinalizeEnterDTO extends DataTransferObject
{
    public string $phone;

    public string $verify_code;
}
