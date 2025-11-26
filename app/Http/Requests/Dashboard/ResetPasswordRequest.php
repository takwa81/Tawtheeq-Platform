<?php

namespace App\Http\Requests\messages;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'password' => 'required|string|min:6|confirmed',
        ];
    }

    public function messages(): array
    {
        return [
            'password.required'  => __('messages.validations.password_required'),
            'password.min'       => __('messages.validations.password_min'),
            'password.confirmed' => __('messages.validations.password_confirmed'),
        ];
    }
}
