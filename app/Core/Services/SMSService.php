<?php

namespace App\Core\Services;

use App\Constants\MessageCode;
use App\Core\Services\Contracts\ResponseServiceInterface;
use App\Core\Services\Contracts\SMSServiceInterface;

class SMSService implements SMSServiceInterface
{
    public function __construct(private ResponseServiceInterface $responseService) {}

    public function sendSMSVerificationCode(): array|string
    {
        $result = true;

        if (! $result) {
            return $this->responseService->result(false, null, MessageCode::ERROR_SMS_100);
        }

        return $this->generateVerificationCode();
    }

    private function generateVerificationCode(): string
    {
        $verificationCodeLength = config('sms.phone_verification_code_length');

        $verificationCode = ''.rand(1, 9);

        for ($i = 0; $i < $verificationCodeLength - 1; $i++) {
            $verificationCode .= rand(0, 9);
        }

        return $verificationCode;
    }
}
