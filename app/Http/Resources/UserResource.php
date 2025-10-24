<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $data = [
            'id' => $this->id,
            'full_name' => $this->full_name,
            'phone_number' => $this->phone_number,
            'user_type' => $this->user_type,
            'status' => $this->status,
        ];

        if ($this->user_type === 'serviceOwner' && $this->relationLoaded('serviceOwner')) {
            $serviceOwner = $this->serviceOwner;

            $data['service_owner_info'] = [
                'id' => $serviceOwner->id,
                'device_code' => $this->device_code,
                'gender' => $serviceOwner->gender,
                'personal_image' => $serviceOwner->image_url,
                'academic_qualification_id' => $serviceOwner->academic_qualification_id,
                'academic_qualification' =>  $serviceOwner->academicQualification?->only(['id', 'name_en', 'name_ar']),
                'age' => $serviceOwner->age,
                'email' => $serviceOwner->email,
                'data_entry_note' => $serviceOwner->data_entry_note,
                'creator_user' => $serviceOwner->creator
                    ? [
                        'id' => $serviceOwner->creator->id,
                        'full_name' => $serviceOwner->creator->full_name,
                        'phone_number' => $serviceOwner->creator->phone_number,
                    ]
                    : null,
            ];
        }

        return $data;
    }
}