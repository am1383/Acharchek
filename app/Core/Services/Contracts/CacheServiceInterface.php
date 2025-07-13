<?php

namespace App\Core\Services\Contracts;

interface CacheServiceInterface
{
    public function putVerificationCode(string $phoneNumber, string $verificationCode): int;

    public function forgetPhoneVerificationCode(string $phoneNumber): void;

    public function getVerificationCodeOrFail(): string;

    public function putSessionKey(string $sessionKey, array $sessionData): void;

    public function put(string $key, mixed $value, int $ttl): void;

    public function forget(string $key): void;

    public function get(string $key): mixed;
}
