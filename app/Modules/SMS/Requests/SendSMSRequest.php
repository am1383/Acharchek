<?php

namespace App\Modules\SMS\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendSMSRequest extends FormRequest
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
            'phone' => 'required|string|min:11|regex:/^09\d{9}$/',
            'hash_link' => 'required|string',
        ];
    }
}
