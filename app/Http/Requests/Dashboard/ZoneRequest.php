<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ZoneRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $zoneId = $this->route('zone');
        return [
            'name_ar' => [
                'required',
                'string',
                'max:255',
                Rule::unique('zones')->where(function ($query) {
                    return $query->where('governorate_id', $this->governorate_id);
                })->ignore($zoneId),
            ],
            'name_en' => [
                'required',
                'string',
                'max:255',
                Rule::unique('zones')->where(function ($query) {
                    return $query->where('governorate_id', $this->governorate_id);
                })->ignore($zoneId),
            ],
            'governorate_id' => ['required', 'exists:governorates,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'name_ar.required' => 'الاسم بالعربي مطلوب.',
            'name_ar.unique' => 'الاسم بالعربي موجود مسبقًا ضمن هذه المحافظة.',
            'name_en.required' => 'الاسم بالانكليزي مطلوب.',
            'name_en.unique' => 'الاسم بالانكليزي موجود مسبقًا ضمن هذه المحافظة.',
            'governorate_id.required' => 'المحافظة مطلوبة.',
            'governorate_id.exists' => 'المحافظة المحددة غير موجودة.',
        ];
    }
}
