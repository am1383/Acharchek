<?php

namespace App\Modules\Auth\Contexts;

use App\Modules\Auth\Repositories\Contracts\BusinessRepositoryInterface;
use App\Modules\Auth\Repositories\Contracts\BusinessTypeRepositoryInterface;
use App\Modules\Auth\Repositories\Eloquent\BusinessServiceRepository;

class BusinessContext
{
    public function __construct(
        public readonly BusinessRepositoryInterface $businessRepository,
        public readonly BusinessServiceRepository $businessServiceRepository,
        public readonly BusinessTypeRepositoryInterface $businessTypeRepository,
    ) {}
}
