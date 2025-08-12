<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Modules\Auth\DTOs\LoginDTO;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Resources\LoginResource;
use App\Modules\Auth\Services\Contracts\LoginServiceInterface;

class LoginController
{
    public function __construct(private LoginServiceInterface $loginService) {}

    public function login(LoginRequest $request): LoginResource
    {
        $dto = new LoginDTO($request->validated());

        return new LoginResource($this->loginService
            ->handleLogin($dto->phone, $dto->verify_code, $dto->device_info));
    }
}
