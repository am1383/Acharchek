<?php

namespace App\Modules\Auth\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->guest();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'register_session_key' => 'required|string|max:200',
            'business_type_id' => 'required|int|exists:business_types,id',
            'business_province_id' => 'required|int|exists:provinces,id',
            'business_city_id' => 'required|int|exists:cities,id',
            'user_full_name' => 'required|string|min:5|max:35',
            'business_title' => 'required|string|min:5|max:35',
            'business_tel' => 'nullable|min:3|max:11',
            'business_address' => 'required|string|min:10|max:200',
            'business_services_ids' => 'nullable|array',
        ];
    }
}
