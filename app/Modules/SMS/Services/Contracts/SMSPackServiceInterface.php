<?php

namespace App\Modules\SMS\Services\Contracts;

use App\Modules\SMS\Models\SMSPack;

interface SMSPackServiceInterface
{
    public function getDetailsById(int $id): SMSPack;

    public function getSMSPacks(string $appVersion): array;
}
