<?php

namespace App\Http\Requests\Api;

use App\Traits\FailedValidationTrait;
use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
{
    use FailedValidationTrait;

    public function rules(): array
    {
        return [
            'service_name_en' => ['nullable', 'string', 'max:255'],
            'service_name_ar' => ['nullable', 'string', 'max:255'],
            'phone_number' => ['nullable', 'string', 'max:20'],
            'alternative_phone_number' => ['nullable', 'string', 'max:20'],
            'description_en' => ['nullable', 'string'],
            'description_ar' => ['nullable', 'string'],
            'email_address' => ['nullable', 'email'],
            'managing_user_id'=>['nullable', 'exists:users,id'],
            'service_type_id' => ['nullable', 'exists:service_types,id'],
            'subscription_id' => ['nullable', 'exists:subscriptions,id'],
            'country_id' => ['nullable', 'exists:countries,id'],
            'governorate_id' => ['nullable', 'exists:governorates,id'],
            'zone_id' => ['nullable', 'exists:zones,id'],
            'location_type' => ['nullable', 'in:map,no_location,hybrid'],
            'location_on_map_lat' => ['nullable'],
            'location_on_map_long' => ['nullable'],
            'location_text_en' => ['nullable', 'string'],
            'location_text_ar' => ['nullable', 'string'],
            'offers_delivery' => ['nullable', 'boolean'],
            'known_as' => ['nullable', 'string'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['integer', 'exists:tags,id'],
            'is_open_now' => ['nullable', 'boolean'],
            'data_entry_note' => ['nullable', 'string'],
            'entry_status' => ['nullable', 'in:draft,locked'],
        ];
    }

}
