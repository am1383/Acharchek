<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Modules\Auth\DTOs\RegisterDTO;
use App\Modules\Auth\Requests\RegisterRequest;
use App\Modules\Auth\Resources\RegisterResource;
use App\Modules\Auth\Services\Contracts\RegisterServiceInterface;

class RegisterController
{
    public function __construct(private RegisterServiceInterface $registerService) {}

    public function register(RegisterRequest $request): RegisterResource
    {
        $registerDTO = RegisterDTO::fromRequest($request->validated());

        return new RegisterResource($this->registerService
            ->register($registerDTO));
    }
}
