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
            'name_ar.required'         => __('dashboard.package_name_ar_required'),
            'name_en.required'         => __('dashboard.package_name_en_required'),
            'name_ar.unique'           => __('dashboard.package_name_ar_unique'),
            'name_en.unique'           => __('dashboard.package_name_en_unique'),
            'branches_limit.unique'    => __('dashboard.package_branches_limit_unique'),
            'branches_limit.required'  => __('dashboard.package_branches_limit_required'),
            'price.required'           => __('dashboard.package_price_required'),
            'price.numeric'            => __('dashboard.package_price_numeric'),
            'price.min'                => __('dashboard.package_price_min'),
            'duration_days.integer'    => __('dashboard.package_duration_integer'),
            'duration_days.min'        => __('dashboard.package_duration_min'),
        ];
    }
}