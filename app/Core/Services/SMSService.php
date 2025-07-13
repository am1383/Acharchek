<?php

namespace App\Core\Services;

use App\Core\Services\Contracts\SMSServiceInterface;

class SMSService implements SMSServiceInterface
{
    public function __construct() {}

    public function sendSMSVerificationCode(): string
    {
        return $this->generateVerificationCode();
    }

    private function generateVerificationCode(): string
    {
        $length = config('sms.phone_verification_code_length');

        return (string) rand(10 ** ($length - 1), (10 ** $length) - 1);
    }
}
