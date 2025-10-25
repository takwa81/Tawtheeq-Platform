<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SubscriptionPackageRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $id = $this->route('subscription_package') ?? $this->id;
        return [
            'name_ar' => [
                'required',
                'string',
                'max:255',
                Rule::unique('subscription_packages', 'name_ar')->ignore($id),
            ],
            'name_en' => [
                'required',
                'string',
                'max:255',
                Rule::unique('subscription_packages', 'name_en')->ignore($id),
            ],
            'branches_limit' => [
                'required',
                'integer',
                'min:1',
                Rule::unique('subscription_packages', 'branches_limit')->ignore($id),
            ],
            'price' => ['required', 'numeric', 'min:0'],
            'duration_days' => ['nullable', 'integer', 'min:1'],
            'description_ar' => ['nullable', 'string'],
            'description_en' => ['nullable', 'string'],
            'features' => ['nullable', 'array'],
            'features.*' => ['nullable', 'string', 'max:255'],
        ];
    }

    public function messages(): array
    {
        return [
            'name_ar.required' => 'الاسم بالعربية مطلوب',
            'name_en.required' => 'الاسم بالإنجليزية مطلوب',
            'name_ar.unique' => 'الاسم بالعربية مستخدم من قبل',
            'name_en.unique' => 'الاسم بالإنجليزية مستخدم من قبل',
            'branches_limit.unique' => 'حد الفروع مستخدم من قبل',
            'branches_limit.required' => 'عدد الفروع مطلوب',
            'price.required' => 'السعر مطلوب',
        ];
    }
}
