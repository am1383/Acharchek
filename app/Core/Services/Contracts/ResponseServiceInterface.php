<?php

namespace App\Core\Services\Contracts;

interface ResponseServiceInterface
{
    public function result(bool $status, ?array $data = null, ?string $messageCode = null, ?string $message = null): array;
}
