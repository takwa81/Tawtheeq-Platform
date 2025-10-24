<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ServiceScheduleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'schedules' => ['required', 'array', 'min:1'],
            'schedules.*.day' => ['required', 'in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday'],
            'schedules.*.is_holiday' => ['nullable', 'boolean'],
            'schedules.*.from_hour' => ['nullable'],
            'schedules.*.to_hour' => ['nullable'],
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $days = collect($this->schedules ?? [])->pluck('day')->toArray();

            if (count($days) !== count(array_unique($days))) {
                $validator->errors()->add('schedules', 'Duplicate days are not allowed.');
            }
        });
    }

    public function messages(): array
    {
        return [
            'schedules.required' => __('messages.service_schedule_required'),
            'schedules.array' => __('messages.service_schedule_array'),
            'schedules.*.day.required' => __('messages.service_schedule_day_required'),
            'schedules.*.day.in' => __('messages.service_schedule_day_invalid'),
            'schedules.*.from_hour.date_format' => __('messages.service_schedule_from_hour_format'),
            'schedules.*.to_hour.date_format' => __('messages.service_schedule_to_hour_format'),
            'schedules.*.to_hour.after' => __('messages.service_schedule_to_hour_after_from'),
        ];
    }
}
