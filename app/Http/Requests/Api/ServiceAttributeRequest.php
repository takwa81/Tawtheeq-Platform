<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FailedValidationTrait;

class ServiceAttributeRequest extends FormRequest
{
    use FailedValidationTrait;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'attributes'=>['required','array'],
            'attributes.*.attribute_key_id' => ['required', 'exists:attribute_keys,id'],
            'attributes.*.attribute_key_option_id' => ['required_without:value', 'exists:attribute_key_options,id'],
            'attributes.*.value' => ['required_without:attribute_key_option_id', 'string'],
        ];
    }
    public function messages(){
        return[
            'attributes.required' => __('messages.attribute_key_required'),
            'attributes.*.attribute_key_id.required' => __('messages.attribute_key_required'),
            'attributes.*.attribute_key_id.exists' => __('messages.attribute_key_exists'),

            'attributes.*.attribute_key_option_id.required_without' => __('messages.attribute_value_required_without'),
            'attributes.*.attribute_key_option_id.exists' => __('messages.key_attribute_option_exists'),

            'attributes.*.value.required_without' => __('messages.attribute_value_required_without'),
            'attributes.*.value.string' => __('messages.value_string'),
        ];
    }
}
