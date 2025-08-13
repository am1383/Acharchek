<?php

namespace App\Modules\Customer\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class GetPhoneNumberDTO extends DataTransferObject
{
    public string $customer_secret;
}
