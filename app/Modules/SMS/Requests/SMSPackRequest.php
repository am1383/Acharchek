<?php

namespace App\Modules\SMS\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SMSPackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }
}
