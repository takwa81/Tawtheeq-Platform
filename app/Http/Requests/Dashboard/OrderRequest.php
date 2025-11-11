<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $user = auth()->user();
        return [
            'branch_id' => [
                $user && $user->role === 'branch' ? 'nullable' : 'required',
                'exists:branches,id',
            ],
            'company_id' => ['required', 'exists:companies,id'],
            'total_order' => ['required', 'numeric', 'min:0'],
            'date' => ['required', 'date'],
            'time' => ['required'],
            'customer_name' => ['nullable', 'string', 'max:255'],
            'driver_name' => ['nullable', 'string', 'max:255'],
            'customer_phone' => ['nullable', 'string', 'max:20'],
            'order_image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'notes' => ['nullable', 'string'],
            'order_number' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'branch_id.required'      => __('dashboard.order_branch_required'),
            'company_id.required'     => __('dashboard.order_company_required'),
            'total_order.required'    => __('dashboard.order_total_required'),
            'total_order.numeric'     => __('dashboard.order_total_numeric'),
            'total_order.min'         => __('dashboard.order_total_min'),
            'date.required'           => __('dashboard.order_date_required'),
            'date.date'               => __('dashboard.order_date_invalid'),
            'time.required'           => __('dashboard.order_time_required'),
            'order_image.required'    => __('dashboard.order_image_required'),
            'order_image.image'       => __('dashboard.order_image_type'),
            'order_image.mimes'       => __('dashboard.order_image_mimes'),
            'order_image.max'         => __('dashboard.order_image_max'),
            'order_number.required'   => __('dashboard.order_number_required'),
        ];
    }
}