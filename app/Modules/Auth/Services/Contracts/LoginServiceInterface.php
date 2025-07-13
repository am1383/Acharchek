<?php

namespace App\Modules\Auth\Services\Contracts;

use App\Modules\Auth\DTOs\LoginDTO;
use App\Modules\Auth\DTOs\VerifyLoginDTO;

interface LoginServiceInterface
{
    public function handleLogin(LoginDTO $loginDTO): array;

    public function verifyLogin(VerifyLoginDTO $verifyLoginDTO): array;
}
