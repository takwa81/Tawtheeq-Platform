<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        Log::info('UserRequest detected service_owners route: ' . $this->route()->getName());

        $id = $this->route('data_entry') ?? $this->route('service_owner');
        $rules = [
            'full_name' => ['required', 'string', 'max:255'],
            'phone_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'phone_number')->ignore($id),
            ],
            'password' => $this->isMethod('post')
                ? ['required', 'string', 'min:6', 'confirmed']
                : ['nullable', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => $this->isMethod('post')
                ? ['required']
                : ['nullable'],
        ];

        if ($this->routeIs('dashboard.service_owners.*')) {
            Log::info('UserRequest matched service_owners route');
            $rules = array_merge($rules, [
                'gender' => ['nullable', 'in:male,female'],
                'academic_qualification_id' => ['nullable', 'exists:academic_qualifications,id'],
                'age' => ['nullable', 'integer'],
                'email' => ['nullable', 'email'],
                'personal_image_path' => ['nullable', 'image', 'max:2048'],
                'data_entry_note' => ['nullable', 'string'],
                'creator_user_id' => ['nullable', 'exists:users,id'],
            ]);
        }


        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'full_name.required' => 'الاسم الكامل مطلوب',
            'phone_number.required' => 'رقم الهاتف مطلوب',
            'phone_number.unique' => 'رقم الهاتف مستخدم مسبقاً',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min' => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
            'password.confirmed' => 'تأكيد كلمة المرور غير مطابق',
        ];

        if ($this->routeIs('service_owners.*')) {
            $messages = array_merge($messages, [
                'gender.required' => 'الجنس مطلوب',
                'gender.in' => 'الجنس يجب أن يكون ذكر أو أنثى',
                'academic_qualification_id.required' => 'المؤهل الأكاديمي مطلوب',
                'academic_qualification_id.exists' => 'المؤهل الأكاديمي غير صالح',
                'age.required' => 'العمر مطلوب',
                'age.integer' => 'العمر يجب أن يكون رقم',
                'age.min' => 'العمر يجب أن يكون 18 على الأقل',
                'email.required' => 'البريد الإلكتروني مطلوب',
                'email.email' => 'البريد الإلكتروني غير صالح',
                'personal_image_path.required' => 'الصورة الشخصية مطلوبة',
                'personal_image_path.image' => 'الصورة الشخصية يجب أن تكون ملف صورة',
                'personal_image_path.max' => 'حجم الصورة يجب ألا يتجاوز 2MB',
                'data_entry_note.required' => 'ملاحظة إدخال البيانات مطلوبة',
            ]);
        }

        return $messages;
    }
}
