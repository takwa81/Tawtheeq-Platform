<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name_en'     => 'required|string|max:100|unique:companies,name_en,' . $this->id,
            'name_ar'     => 'required|string|max:100|unique:companies,name_ar,' . $this->id,
            'logo' => [$this->isMethod('post') ? 'required' : 'nullable', 'image', 'max:2048'],

        ];
    }

    public function messages(): array
    {
        return [
            'name_ar.required' => 'الاسم بالعربي مطلوب',
            'name_ar.string' => 'الاسم بالعربي يجب أن يكون نص',
            'name_ar.max' => 'الاسم بالعربي يجب ألا يتجاوز 255 حرفًا',
            'name_ar.unique' => 'هذا الاسم بالعربي مستخدم بالفعل',

            'name_en.required' => 'الاسم بالانكليزي مطلوب',
            'name_en.string' => 'الاسم بالانكليزي يجب أن يكون نص',
            'name_en.max' => 'الاسم بالانكليزي يجب ألا يتجاوز 255 حرفًا',
            'name_en.unique' => 'هذا الاسم بالانكليزي مستخدم بالفعل',
        ];
    }
}