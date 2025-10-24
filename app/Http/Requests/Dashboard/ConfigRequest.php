<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
{
    
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'version_app'=>'required',
        ];
    }

     public function messages(): array
    {
        return [
            'version_app.required' => 'نسخة التطبيق مطلوبة',

        ];
    }
}
