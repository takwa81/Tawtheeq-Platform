<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SocialMediaRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $id = $this->route('social_media');

        return [
            'name_ar' => [
                'required',
                'string',
                Rule::unique('social_media', 'name_ar')->ignore($id),
            ],
            'name_en' => [
                'required',
                'string',
                Rule::unique('social_media', 'name_en')->ignore($id),
            ],
            'image' => [$this->isMethod('post') ? 'required' : 'nullable', 'image', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            'name_ar.required' => 'حقل الاسم بالعربي مطلوب.',
            'name_ar.string' => 'حقل الاسم بالعربي يجب أن يكون نصاً.',
            'name_ar.unique' => 'الاسم بالعربي موجود مسبقاً.',

            'name_en.required' => 'حقل الاسم بالانكليزي مطلوب.',
            'name_en.string' => 'حقل الاسم بالانكليزي يجب أن يكون نصاً.',
            'name_en.unique' => 'الاسم بالانكليزي موجود مسبقاً.',

            'image.required' => 'حقل الصورة مطلوب.',
            'image.image' => 'يجب أن تكون الصورة بصيغة صحيحة.',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 2 ميغابايت.',
        ];
    }
}
