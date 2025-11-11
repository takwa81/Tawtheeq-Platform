<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $companyId = $this->route('company');

        return [
            'name_ar' => [
                'required',
                'string',
                'max:255',
                Rule::unique('companies', 'name_ar')->ignore($companyId),
            ],
            'name_en' => [
                'required',
                'string',
                'max:255',
                Rule::unique('companies', 'name_en')->ignore($companyId),
            ],
            'logo' => [$this->isMethod('post') ? 'required' : 'nullable', 'image', 'max:2048'],

        ];
    }

    public function messages(): array
    {
        return [
            'name_ar.required' => __('dashboard.company_name_ar_required'),
            'name_ar.string'   => __('dashboard.company_name_ar_string'),
            'name_ar.max'      => __('dashboard.company_name_ar_max'),
            'name_ar.unique'   => __('dashboard.company_name_ar_unique'),

            'name_en.required' => __('dashboard.company_name_en_required'),
            'name_en.string'   => __('dashboard.company_name_en_string'),
            'name_en.max'      => __('dashboard.company_name_en_max'),
            'name_en.unique'   => __('dashboard.company_name_en_unique'),

            'logo.required'    => __('dashboard.company_logo_required'),
            'logo.image'       => __('dashboard.company_logo_image'),
            'logo.max'         => __('dashboard.company_logo_max'),
        ];
    }
}