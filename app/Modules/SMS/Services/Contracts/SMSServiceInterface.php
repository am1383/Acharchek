<?php

namespace App\Modules\SMS\Services\Contracts;

interface SMSServiceInterface
{
    public function send(string $phoneNumber, string $hashLink): array;

    public function getPriceInformation(): array;
}
