<?php

namespace App\Http\Requests\Api;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{
    use FailedValidationTrait;

    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'current_password' => ['required'],
            'new_password' => ['required', 'confirmed','min:6'],
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => __('messages.current_password_required'),
            'new_password.required' => __('messages.new_password_required'),
            'new_password.confirmed' => __('messages.new_password_confirmation'),
            'new_password.min' => __('messages.new_password_min'),
        ];
    }
}
