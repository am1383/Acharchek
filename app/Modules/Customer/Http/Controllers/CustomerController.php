<?php

namespace App\Modules\Customer\Http\Controllers;

use App\Modules\Admin\Requests\FinalizeEnterRequest;
use App\Modules\Admin\Requests\TryEnterRequest;
use App\Modules\Customer\DTOs\FinalizeEnterDTO;
use App\Modules\Customer\DTOs\TryEnterDTO;
use App\Modules\Customer\Resources\FinalizeEnterResource;
use App\Modules\Customer\Resources\TryEnterResource;
use App\Modules\Customer\Services\CustomerServiceInterface;

class CustomerController
{
    public function __construct(private CustomerServiceInterface $customerService) {}

    public function tryEnter(TryEnterRequest $request): TryEnterResource
    {
        $dto = new TryEnterDTO($request->validated());

        return new TryEnterResource($this->customerService
            ->tryEnter($dto->phone, $dto->hash_link));
    }

    public function finalizeEnter(FinalizeEnterRequest $request): FinalizeEnterResource
    {
        $dto = new FinalizeEnterDTO($request->validated());

        return new FinalizeEnterResource($this->customerService
            ->finalizeEnter($dto->phone, $dto->verify_code));
    }
}
