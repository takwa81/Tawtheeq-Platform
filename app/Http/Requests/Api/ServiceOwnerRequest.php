<?php

namespace App\Http\Requests\Api;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceOwnerRequest extends FormRequest
{
    use FailedValidationTrait;

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $id = $this->route('service_owner');
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'phone_number' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'phone_number')->ignore($id),
            ],

            'gender' => ['nullable', 'in:male,female'],
            'academic_qualification_id' => ['nullable', 'exists:academic_qualifications,id'],
            'age' => ['nullable', 'integer'],
            'email' => ['nullable', 'email'],
            'personal_image_path' => ['nullable', 'image', 'max:2048'],
            'data_entry_note' => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'full_name.required' => __('messages.full_name_required'),
            'full_name.string' => __('messages.full_name_string'),
            'full_name.max' => __('messages.full_name_max'),

            'phone_number.required' => __('messages.phone_number_required'),
            'phone_number.string' => __('messages.phone_number_string'),
            'phone_number.max' => __('messages.phone_number_max'),
            'phone_number.unique' => __('messages.phone_number_unique'),

            'gender.in' => __('messages.gender_in'),

            'academic_qualification_id.exists' => __('messages.academic_qualification_id_exists'),

            'age.integer' => __('messages.age_integer'),

            'email.email' => __('messages.email_email'),

            'personal_image_path.image' => __('messages.personal_image_path_image'),
            'personal_image_path.max' => __('messages.personal_image_path_max'),

            'data_entry_note.string' => __('messages.data_entry_note_string'),

        ];
    }
}
