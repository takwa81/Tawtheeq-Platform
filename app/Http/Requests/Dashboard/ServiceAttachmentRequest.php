<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ServiceAttachmentRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'attachment_type' => ['required', Rule::in(['360', 'image_video'])],
            'attachment_file' => ['required', 'file', 'max:51200'],
        ];
    }

    public function messages(): array
    {
        return [
            'attachment_type.required' => 'يرجى اختيار نوع المرفق.',
            'attachment_file.required' => 'يرجى رفع ملف المرفق.',
        ];
    }

    public function getDetectedAttachmentType(): string
    {
        $type = $this->input('attachment_type');
        if ($type === '360') {
            return '360';
        }

        $extension = strtolower($this->file('attachment_file')->getClientOriginalExtension());
        $imageExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $videoExt = ['mp4', 'mov', 'avi', 'mkv', 'webm'];

        if (in_array($extension, $imageExt)) {
            return 'image';
        } elseif (in_array($extension, $videoExt)) {
            return 'video';
        }

        return 'image';
    }
}
