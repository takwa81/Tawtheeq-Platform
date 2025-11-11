<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        Log::info('UserRequest detected service_owners route: ' . $this->route()->getName());

        $id = $this->route('branch_manager') ?? $this->route('branch');
        $rules = [
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => [
                'required',
                'string',
                'max:20',
                Rule::unique('users', 'phone')->ignore($id),
            ],
            'password' => $this->isMethod('post')
                ? ['required', 'string', 'min:6', 'confirmed']
                : ['nullable', 'string', 'min:6', 'confirmed'],
            'password_confirmation' => $this->isMethod('post')
                ? ['required']
                : ['nullable'],
            'email' => [
                'nullable',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($id),
            ],
        ];

        if ($this->routeIs('dashboard.branches.*')) {
            Log::info('UserRequest matched branch route');
            if (auth()->user()->role !== 'branch_manager') {
                $rules['manager_id'] = ['required', 'exists:users,id'];
            } else {
                $rules['manager_id'] = ['nullable', 'exists:users,id'];
            }
            $rules['branch_number'] = ['required'];
        }


        return $rules;
    }

    public function messages(): array
    {
        return [
            'full_name.required'             => __('dashboard.full_name_required'),
            'branch_number.required'         => __('dashboard.branch_number_required'),
            'phone.required'                 => __('dashboard.phone_required'),
            'phone.unique'                   => __('dashboard.phone_unique'),
            'password.required'              => __('dashboard.password_required'),
            'password.min'                   => __('dashboard.password_min'),
            'password.confirmed'             => __('dashboard.password_confirmed'),
            'email.email'                     => __('dashboard.email_invalid'),
            'email.unique'                    => __('dashboard.email_unique'),
            'manager_id.required'             => __('dashboard.manager_required'),
            'manager_id.exists'               => __('dashboard.manager_exists'),
        ];
    }
}