<?php

namespace App\Modules\User\Http\Controllers;

use App\Modules\User\DTOs\FullUserInfoDTO;
use App\Modules\User\DTOs\SecondUserInfoDTO;
use App\Modules\User\DTOs\UserInfoDTO;
use App\Modules\User\Requests\FullUserInfoRequest;
use App\Modules\User\Requests\SecondUserInfoRequest;
use App\Modules\User\Requests\UserInfoRequest;
use App\Modules\User\Resources\FullUserInfoResource;
use App\Modules\User\Resources\SecondUserInfoResource;
use App\Modules\User\Resources\UserInfoResource;
use App\Modules\User\Services\Contracts\UserServiceInterface;

class UserController
{
    public function __construct(private UserServiceInterface $userService) {}

    public function userInformation(UserInfoRequest $request): UserInfoResource
    {
        $dto = new UserInfoDTO($request->validated());

        return new UserInfoResource($this->userService
            ->getInformation($dto->api_token));
    }

    public function secondUserInformation(SecondUserInfoRequest $request): SecondUserInfoResource
    {
        $dto = new SecondUserInfoDTO($request->validated());

        return new SecondUserInfoResource($this->userService
            ->getSecondUserInformation($dto->api_token));
    }

    public function fullUserInfo(FullUserInfoRequest $request): FullUserInfoResource
    {
        $dto = new FullUserInfoDTO($request->validated());

        return new FullUserInfoResource($this->userService
            ->getFullUserInformation($dto->api_token));
    }
}
