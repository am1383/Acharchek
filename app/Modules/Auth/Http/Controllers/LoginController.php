<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Modules\Auth\DTOs\LoginDTO;
use App\Modules\Auth\DTOs\VerifyLoginDTO;
use App\Modules\Auth\Requests\LoginRequest;
use App\Modules\Auth\Resources\LoginResource;
use App\Modules\Auth\Services\Contracts\LoginServiceInterface;

class LoginController
{
    public function __construct(private LoginServiceInterface $loginService) {}

    public function login(LoginRequest $request): LoginResource
    {
        $loginDTO = LoginDTO::fromRequest($request->validated());

        return new LoginResource($this->loginService->handleLogin($loginDTO));
    }

    public function verifyLogin(LoginRequest $request)
    {
        $verifyLoginDTO = VerifyLoginDTO::fromRequest($request->validated());

    }
}
