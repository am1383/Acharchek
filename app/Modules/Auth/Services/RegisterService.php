<?php

namespace App\Modules\Auth\Services;

use App\Constants\Constants;
use App\Constants\MessageCode;
use App\Core\Services\Contracts\CacheServiceInterface;
use App\Core\Services\Contracts\RateLimitServiceInterface;
use App\Events\NewLogin;
use App\Events\NewRegister;
use App\Helpers\ResponseHelper;
use App\Modules\Auth\Contexts\BusinessContext;
use App\Modules\Auth\Contexts\LocationContext;
use App\Modules\Auth\DTOs\RegisterDTO;
use App\Modules\Auth\Models\User;
use App\Modules\Auth\Repositories\Contracts\UserRepositoryInterface;
use App\Modules\Auth\Resources\LoginResource;
use App\Modules\Auth\Services\Contracts\RegisterServiceInterface;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RegisterService implements RegisterServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private BusinessContext $business,
        private LocationContext $location,
        private RateLimitServiceInterface $rateLimitService,
        private CacheServiceInterface $cacheService
    ) {}

    public function register(RegisterDTO $registerDTO): array
    {
        $sessionKey = $registerDTO->sessionKey;
        $businessTel = $registerDTO->businessTel;

        $sessionData = $this->cacheService->get($sessionKey);

        $businessType = $this->business->businessTypeRepository
            ->findOrFail($registerDTO->businessTypeId, ['id', 'title']);

        $businessProvince = $this->location->provinceRepository
            ->findOrFail($registerDTO->businessProvinceId, ['id', 'title']);

        $businessCity = $this->location->cityRepository->findOrFailById($registerDTO->businessCityId, $businessProvince->id, ['id', 'title']);

        $businessServicesIds = '';

        if (! empty($businessServicesIds)) {
            $validIds = $this->business->businessServiceRepository->getAllIds();
            $inputIds = array_map('trim', explode('-', $businessServicesIds));

            $filteredIds = array_filter($inputIds, function ($id) use ($validIds) {
                return ctype_digit($id) && in_array($id, $validIds);
            });
            $businessServicesIds = implode('-', $filteredIds);
        }

        DB::beginTransaction();

        try {
            $user = $this->userRepository->create([
                'phone' => $sessionData['phone'],
                'full_name' => $registerDTO->userFullName,
                'sms_credit' => 0,
                'active_business_id' => $businessServicesIds,
                'is_business_owner' => 1,
                'registered_at' => now()->toDateTimeString(),
            ]);

            $activeBusinessId = $this->business->businessRepository->create([
                'user_id' => $user->id,
                'type_id' => $businessType->id,
                'type_title' => $businessType->title,
                'title' => $registerDTO->businessTitle,
                'tel' => $businessTel ? $businessTel : null,
                'province_id' => $businessProvince->id,
                'province_title' => $businessProvince->title,
                'city_id' => $businessCity->id,
                'city_title' => $businessCity->title,
                'address' => $registerDTO->businessAddress,
                'services_ids' => $businessServicesIds ? $businessServicesIds : null,
                'phone' => $sessionData['phone'],
                'registered_at' => now()->toDateTimeString(),
            ]);

            $this->userRepository->updateOrFail([
                'active_business_id' => $activeBusinessId,
                'is_business_owner' => 1,
            ]);

            DB::commit();

            $this->cacheService->forget($sessionKey);

            event(new NewRegister($user, true));

            $this->hitRateLimitKey($registerDTO->ip);

            $data = $this->prepareUserInfo($user);

            Auth::login($user);

            event(new NewLogin($user, true));

            return ResponseHelper::result(true, $data);
        } catch (Exception $ex) {
            DB::rollBack();

            return ResponseHelper::result(false, null, MessageCode::ERROR_DATABASE_100);
        }
    }

    private function prepareUserInfo(User $user): array
    {
        return [
            'user_info' => new LoginResource($user),
        ];
    }

    private function hitRateLimitKey(string $ip): void
    {
        $ipKey = Constants::PREFIX_VERIFY_REGISTER.$ip;

        $this->rateLimitService->hit($ipKey);
    }
}
