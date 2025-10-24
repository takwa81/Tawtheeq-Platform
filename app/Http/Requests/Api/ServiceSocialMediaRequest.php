<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FailedValidationTrait;

class ServiceSocialMediaRequest extends FormRequest
{
    use FailedValidationTrait;
 
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'social_media' => ['nullable', 'array'],
            'social_media.*.social_media_id' => [
                'nullable',
                'exists:social_media,id',
            ],
            'social_media.*.link' => [
                'nullable',
                'string',
            ],
        ];
    }
    public function messages(): array
    {
        return [
            'social_media.required' => __("messages.social_media_required"),
            'social_media.array' => __("messages.social_media_array"),
            'social_media.*.social_media_id.required' =>  __("messages.social_media_id_required"),
            'social_media.*.social_media_id.exists' =>  __("messages.social_media_id_exists"),
            'social_media.*.link.string' => __("messages.link_string"),
        ];
    }
}
