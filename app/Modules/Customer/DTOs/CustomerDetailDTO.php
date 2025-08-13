<?php

namespace App\Modules\Customer\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class CustomerDetailDTO extends DataTransferObject
{
    public string $customer_secret;
}
