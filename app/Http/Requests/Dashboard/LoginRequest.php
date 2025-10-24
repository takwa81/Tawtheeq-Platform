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
            'phone.required' => 'رقم الهاتف مطلوب.',
            'phone.numeric' => 'يجب أن يكون رقم الهاتف رقمًا صحيحًا.',
            'phone.digits' => 'يجب أن يكون رقم الهاتف مكونًا من 10 أرقام.',
            'phone.exists' => 'رقم الهاتف غير مسجل لدينا.',
            'password.required' => 'كلمة المرور مطلوبة.',
            'password.min' => 'يجب أن تتكون كلمة المرور من 6 أحرف على الأقل.',
        ];
    }
}
