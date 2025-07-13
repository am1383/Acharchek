<?php

namespace App\Modules\Auth\DTOs;

use App\Modules\Auth\Requests\RegisterRequest;
use Spatie\DataTransferObject\DataTransferObject;

class RegisterDTO extends DataTransferObject
{
    public function __construct(
        public readonly string $sessionKey,
        public readonly string $ip,
        public readonly string $userFullName,
        public readonly string $businessTitle,
        public readonly string $businessTel,
        public readonly string $businessAddress,
        public readonly int $businessTypeId,
        public readonly int $businessProvinceId,
        public readonly int $businessCityId,
        public readonly array $businessServiceIds

    ) {}

    public static function fromRequest(RegisterRequest $request): self
    {
        return new self(
            $request->register_session_key,
            $request->ip(),
            $request->user_full_name,
            $request->business_title,
            $request->business_tel,
            $request->business_address,
            $request->business_type_id,
            $request->business_province_id,
            $request->business_city_id,
            $request->business_services_ids
        );
    }
}
