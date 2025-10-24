<?php

namespace App\Http\Requests\Api;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
{
    use FailedValidationTrait;

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'service_name_en' => ['nullable', 'string', 'max:255'],
            'service_name_ar' => ['nullable', 'string', 'max:255'],
        ];
    }


    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (!$this->service_name_en && !$this->service_name_ar) {
                $validator->errors()->add('service_name', __('messages.service_name_required'));
            }
        });
    }

     public function messages(): array
    {
        return [
            'service_name_en.max' => __('messages.service_name_en_max'),
            'service_name_ar.max' => __('messages.service_name_ar_max'),
        ];
    }
}
