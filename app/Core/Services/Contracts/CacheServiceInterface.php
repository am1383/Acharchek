<?php

namespace App\Core\Services\Contracts;

interface CacheServiceInterface
{
    public function putVerificationCode(string $phoneNumber, string $verificationCode): int;
}
