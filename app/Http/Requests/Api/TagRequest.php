<?php

namespace App\Http\Requests\Api;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    use FailedValidationTrait;

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        $id = $this->route('tag') ?? $this->id ?? null;

        return [
            'name_ar' => ['required', 'string', 'max:255', 'unique:tags,name_ar,' . $id],
            'name_en' => ['required', 'string', 'max:255', 'unique:tags,name_en,' . $id],
        ];
    }

    public function messages(): array
    {
        return [
            'name_ar.required' => __("messages.name_ar_required"),
            'name_ar.string'   => __("messages.name_ar_string"),
            'name_ar.max'      => __("messages.name_ar_max"),
            'name_ar.unique'   => __("messages.name_ar_unique"),

            'name_en.required' => __("messages.name_en_required"),
            'name_en.string'   => __("messages.name_en_string"),
            'name_en.max'      => __("messages.name_en_max"),
            'name_en.unique'   => __("messages.name_en_unique"),
        ];
    }
}
