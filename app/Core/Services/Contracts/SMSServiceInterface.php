<?php

namespace App\Core\Services\Contracts;

interface SMSServiceInterface
{
    public function sendSMSVerificationCode(): array|string;
}
