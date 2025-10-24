<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GovernorateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $governorateId = $this->route('governorate');

        return [
            'name_ar' => [
                'required',
                'string',
                'max:255',
                Rule::unique('governorates', 'name_ar')->ignore($governorateId),
            ],
            'name_en' => [
                'required',
                'string',
                'max:255',
                Rule::unique('governorates', 'name_en')->ignore($governorateId),
            ],
            'country_id' => [
                'required',
                'exists:countries,id',
            ],
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
            'country_id.required' => 'يجب اختيار الدولة',
            'country_id.exists'   => 'الدولة المختارة غير موجودة',
        ];
    }
}
