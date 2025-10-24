<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ServiceSocialMediaRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'socials' => 'array',
            'socials.*.id' => 'required|exists:social_media,id',
            'socials.*.link' => 'nullable|string|max:255',
        ];
    }
}
