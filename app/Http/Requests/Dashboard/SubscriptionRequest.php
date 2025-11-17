<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class SubscriptionRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }


    public function rules(): array
    {
        return [
            'manager_id' => ['required', 'exists:users,id'],
            'package_id' => ['required', 'exists:subscription_packages,id'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date', 'after_or_equal:start_date'],
        ];
    }

    public function messages(): array
    {
        return [
            'manager_id.required' => __('dashboard.manager_required'),
            'manager_id.exists'   => __('dashboard.manager_not_found'),
            'package_id.required' => __('dashboard.package_required'),
            'package_id.exists'   => __('dashboard.package_not_found'),
            'start_date.required' => __('dashboard.start_date_required'),
            'end_date.required'   => __('dashboard.end_date_required'),
            'end_date.after_or_equal' => __('dashboard.end_date_after_start'),
        ];
    }
}
