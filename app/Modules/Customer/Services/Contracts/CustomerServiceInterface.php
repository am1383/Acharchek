<?php

namespace App\Modules\Customer\Services;

interface CustomerServiceInterface
{
    public function tryEnter(string $phoneNumber, string $hashLink): array;

    public function finalizeEnter(string $phoneNumber, string $verifyCode): array;

    public function getPhoneNumber(string $customerSecret): array;
}
