<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'phone' => 'required|numeric|exists:users,phone',
            'password' => 'required|string|min:6',
        ];
    }

    public function messages(): array
    {
        return [
            'phone.required' => __('dashboard.login_phone_required'),
            'phone.numeric'  => __('dashboard.login_phone_numeric'),
            'phone.exists'   => __('dashboard.login_phone_exists'),

            'password.required' => __('dashboard.login_password_required'),
            'password.min'      => __('dashboard.login_password_min'),
        ];
    }
}