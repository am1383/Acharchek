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
        $loginDTO = new LoginDTO($request->validated());

        return new LoginResource($this->loginService
            ->handleLogin($loginDTO->phone, $loginDTO->verify_code, $loginDTO->device_info));
    }
}
