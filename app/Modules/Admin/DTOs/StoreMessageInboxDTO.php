<?php

namespace App\Modules\Admin\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

class StoreMessageInboxDTO extends DataTransferObject
{
    public string $target_users;

    public string $title;

    public string $content;
}
