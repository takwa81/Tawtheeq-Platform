<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceOwnerResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'full_name' => $this->user?->full_name,
            'phone_number' => $this->user?->phone_number,

            'email' => $this->email,
            'gender' => $this->gender,
            'age' => $this->age,
            'academic_qualification' => $this->academicQualification?->only(['id', 'name_en','name_ar']),
            'data_entry_note' => $this->data_entry_note,
            'image_url' => $this->image_url,
            'attachments' => $this->attachments?->map(fn($att) => [
                'id' => $att->id,
                'attachment_type' => $att->attachment_type,
                'url' => $att->path_to_attachment ? route('files', ['folder' => 'service_attachments', 'filename' => $att->path_to_attachment]) : null,
            ]),
            'creator_user' => $this->whenLoaded('creator', function () {
                return [
                    'id' => $this->creator_user_id,
                    'full_name' => $this->creator?->full_name,
                    'phone_number' => $this->creator?->phone_number,
                ];
            }),
            'created_at' => $this->created_at?->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at?->format('Y-m-d H:i:s'),
        ];
    }
}
