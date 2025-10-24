<?php

namespace App\Http\Requests\Api;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    use FailedValidationTrait;
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'phone_number' => 'required|string',
            'password' => 'required|string|min:6',
            'device_code' => 'nullable|string'
        ];
    }

    public function messages(): array
    {
        return [
            'phone_number.required' => __('messages.phone_number_required'),
            'password.required' => __('messages.password_required'),
            'password.min' => __('messages.password_min'),
        ];
    }
}
