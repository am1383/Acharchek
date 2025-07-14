<?php

namespace App\Modules\Auth\Services\Contracts;

use App\Modules\Auth\DTOs\RegisterDTO;

interface RegisterServiceInterface
{
    public function register(RegisterDTO $registerDTO): array;
}
