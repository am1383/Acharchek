<?php

namespace App\Modules\Customer\Http\Controllers;

use App\Modules\Admin\Requests\CustomerDetailsRequest;
use App\Modules\Admin\Requests\CustomerPhoneNumberResource;
use App\Modules\Admin\Requests\FinalizeEnterRequest;
use App\Modules\Admin\Requests\TryEnterRequest;
use App\Modules\Customer\DTOs\CustomerDetailDTO;
use App\Modules\Customer\DTOs\FinalizeEnterDTO;
use App\Modules\Customer\DTOs\GetPhoneNumberDTO;
use App\Modules\Customer\DTOs\TryEnterDTO;
use App\Modules\Customer\Resources\FinalizeEnterResource;
use App\Modules\Customer\Resources\GetPhoneNumberResource;
use App\Modules\Customer\Resources\TryEnterResource;
use App\Modules\Customer\Services\CustomerServiceInterface;

class CustomerController
{
    public function __construct(private CustomerServiceInterface $customerService) {}

    public function details(CustomerDetailsRequest $request)
    {
        $dto = new CustomerDetailDTO($request->validated());
    }

    public function getPhoneNumber(CustomerPhoneNumberResource $request): GetPhoneNumberResource
    {
        $dto = new GetPhoneNumberDTO($request->validated());

        return new GetPhoneNumberResource($this->customerService
            ->getPhoneNumber($dto->customer_secret));

    }

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
