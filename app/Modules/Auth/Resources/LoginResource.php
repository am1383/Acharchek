<?php

namespace App\Modules\Auth\Resources;

use App\Helpers\DateFormatHelper;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'phone' => $this->phone,
            'full_name' => $this->full_name,
            'sms_credit' => $this->sms_credit,
            'email' => $this->email,

            'email_status' => [
                'verified' => $this->email_verified_at ? true : false,
                'verify_date' => $this->email_verified_at ? DateFormatHelper::dateTime($this->email_verified_at) : null,
            ],

            'national_code' => $this->national_code,
            'birth_date' => $this->birth_date ? DateFormatHelper::dateTime($this->birth_date) : null,
            'ban' => $this->ban ? true : false,
            'registered_at' => DateFormatHelper::dateTime($this->registered_at),
        ];
    }
}
