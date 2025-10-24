<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FailedValidationTrait;
use Illuminate\Validation\Rule;

class AttributeKeyRequest extends FormRequest
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
        $id = $this->route('attribute_key');
        return [
            'key_name' => ['required', 'string', 'max:64','regex:/^[a-zA-Z_][a-zA-Z0-9_]*$/',Rule::unique('attribute_keys', 'key_name')->ignore($id)],
            'data_type' => ['required', 'string', 'in:Text,Number,Boolean,Select'],
            'attribute_key_options' => ['required_if:data_type,Select', 'array'],
            'attribute_key_options.*' => ['string'],
        ];
    }
    public function messages(): array
    {
        return [
            'key_name.required' => __('messages.key_name_required'),
            'key_name.string' => __('messages.key_name_string'),
            'key_name.max' => __('messages.key_name_max'),
            'key_name.regex' => __('messages.key_name_regex'),
            'key_name.unique' => __('messages.key_name_unique'),

            'data_type.required' => __('messages.data_type_required'),
            'data_type.string' => __('messages.data_type_srting'),
            'data_type.in' => __('messages.data_type_in'),

            'attribute_key_options.required_if' => __('messages.attribute_key_options_required_if'),
            'attribute_key_options.array' => __('messages.attribute_key_options_array'),
            'attribute_key_options.*.string' => __('messages.attribute_key_options_values_string')
        ];
    }
}
