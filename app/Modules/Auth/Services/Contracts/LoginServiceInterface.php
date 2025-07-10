<?php

namespace App\Modules\Auth\Services\Contracts;

use App\Modules\Auth\DTOs\LoginDTO;

interface LoginServiceInterface
{
    public function handleLogin(LoginDTO $loginDTO): array;
}
