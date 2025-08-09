<?php

namespace App\Modules\Admin\Services\Contracts;

use App\Modules\Admin\DTOs\StoreMessageInboxDTO;

interface MessageInboxServiceInterface
{
    public function store(StoreMessageInboxDTO $storeMessageInboxDTO): array;
}
