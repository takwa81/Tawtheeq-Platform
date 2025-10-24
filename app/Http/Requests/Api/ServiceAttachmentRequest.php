<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use App\Traits\FailedValidationTrait;

class ServiceAttachmentRequest extends FormRequest
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
            'isPanorama' => 'required|boolean',
            'attachment' => 'required|file|mimes:jpg,jpeg,png,webp,gif,bmp,tiff,heic,mp4,mov,avi,mkv,webm,flv,wmv,mpeg|max:5120',
        ];
    }
    public function messages(): array
    {
        return [
            'isPanorama.required' => __("messages.isPanorama_required"),
            'isPanorama.boolean' => __("messages.isPanorama_boolean"),

            'attachment.required' => __("messages.attachment_required"),
            'attachment.file' => __("messages.attachment_file"),
            'attachment.mimes' => __("messages.attachment_mimes"),
            'attachment.max' => __("messages.attachment_max"),
        ];
    }
}
