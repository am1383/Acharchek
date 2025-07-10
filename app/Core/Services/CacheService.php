<?php

namespace App\Core\Services;

use App\Core\Services\Contracts\CacheServiceInterface;
use Illuminate\Support\Facades\Cache;

class CacheService implements CacheServiceInterface
{
    public function putVerificationCode(string $phoneNumber, string $verificationCode): int
    {
        $phoneVerificationTime = 60 * 4;
        $key = 'phone_verification_'.$phoneNumber;

        $this->put($key, $verificationCode, $phoneVerificationTime);

        return $phoneVerificationTime;
    }

    private function put(string $key, string $value, int $ttl): void
    {
        Cache::put($key, $value, $ttl);
    }
}
