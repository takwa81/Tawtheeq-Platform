<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AcademicQualificationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

   
    public function rules(): array
    {
         $id = $this->route('academic_qualification') ?? $this->id ?? null;

        return [
            'name_ar' => ['required', 'string', 'max:255', 'unique:academic_qualifications,name_ar,' . $id],
            'name_en' => ['required', 'string', 'max:255', 'unique:academic_qualifications,name_en,' . $id],
        ];
    }

    public function messages(): array
    {
        return [
            'name_ar.required' => 'الاسم بالعربي مطلوب',
            'name_ar.string' => 'الاسم بالعربي يجب أن يكون نصًا',
            'name_ar.max' => 'الاسم بالعربي لا يمكن أن يتجاوز 255 حرفًا',
            'name_ar.unique' => 'الاسم بالعربي موجود مسبقًا',

            'name_en.required' => 'الاسم بالانكليزي مطلوب',
            'name_en.string' => 'الاسم بالانكليزي يجب أن يكون نصًا',
            'name_en.max' => 'الاسم بالانكليزي لا يمكن أن يتجاوز 255 حرفًا',
            'name_en.unique' => 'الاسم بالانكليزي موجود مسبقًا',
        ];
    }
}
