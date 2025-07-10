<?php

namespace App\Core\Services\Contracts;

interface CacheServiceInterface
{
    public function putVerificationCode(string $phoneNumber, string $verificationCode): int;

    public function forgetPhoneVerificationCode(string $phoneNumber): void;

    public function getVerificationCodeOrFail(): string;
}
