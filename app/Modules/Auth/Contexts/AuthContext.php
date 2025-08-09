<?php

use App\Core\Repositories\Contracts\UserRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\InformationRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\LoginTriesRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\MobileDeviceRepositoryInterface;

class AuthContext
{
    public function __construct(
        public readonly UserRepositoryInterface $userRepository,
        public readonly InformationRepositoryInterface $informationRepository,
        public readonly MobileDeviceRepositoryInterface $mobileDeviceRepository,
        public readonly LoginTriesRepositoryInterface $loginTriesRepository,
    ) {}
}
