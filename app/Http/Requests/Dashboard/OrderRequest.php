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
            'order_number'=>'required'
        ];
    }

    public function messages(): array
    {
        return [
            'branch_id.required' => 'يجب اختيار الفرع.',
            'company_id.required' => 'يجب اختيار الشركة.',
            'total_order.required' => 'يجب إدخال المبلغ.',
            'date.required' => 'يجب إدخال التاريخ.',
            'time.required' => 'يجب إدخال الوقت.',
        ];
    }
}
