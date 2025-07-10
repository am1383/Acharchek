<?php

namespace App\Modules\Auth\DTOs;

use App\Modules\Auth\Requests\LoginRequest;
use Spatie\DataTransferObject\DataTransferObject;

class LoginDTO extends DataTransferObject
{
    public function __construct(
        public readonly string $phoneNumber,
        public readonly string $ip
    ) {}

    public static function fromRequest(LoginRequest $request): self
    {
        return new self(
            $request->phoneNumber,
            $request->ip()
        );
    }
}
