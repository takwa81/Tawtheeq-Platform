<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'service_name_en' => $this->service_name_en,
            'service_name_ar' => $this->service_name_ar,
            'service_name' => $this->display_name,
            'phone_number' => $this->phone_number,
            'alternative_phone_number' => $this->alternative_phone_number,
            'description_en' => $this->description_en,
            'description_ar' => $this->description_ar,
            'email_address' => $this->email_address,
            'known_as' => $this->known_as,
            'offers_delivery' => (bool) $this->offers_delivery,
            'rating' => $this->rating,
            'number_of_ratings' => $this->number_of_ratings,
            'is_open_now' => (bool) $this->is_open_now,
            'entry_status' => $this->entry_status,
            'status' => $this->status,
            'location_type' => $this->location_type,
            'location_on_map_lat' => $this->location_on_map_lat,
            'location_on_map_long' => $this->location_on_map_long,
            'location_text_en' => $this->location_text_en,
            'location_text_ar' => $this->location_text_ar,
            'offers_delivery' => $this->offers_delivery,
            'known_as' => $this->known_as,
            'rating' => $this->rating,
            'number_of_ratings' => $this->number_of_ratings,
            'is_open_now' => $this->is_open_now,
            'data_entry_note' => $this->data_entry_note,
            'entry_status' => $this->entry_status,
            'status' => $this->status,
            'managing_user' => new UserResource($this->whenLoaded('managingUser')),
            'creator_user' => $this->whenLoaded('creatorUser', function () {
                $name = null;
                $phone = null ;
                if ($this->creator_user_type === \App\Models\Employee::class) {
                    $name = $this->creatorUser?->full_name;
                    $phone = $this->creatorUser?->phone_number;

                } else {
                    $name = $this->creatorUser->user?->full_name ?? null;
                    $phone = $this->creatorUser->user?->phone_number ?? null;

                }
                return [
                    'id' => $this->creator_user_id,
                    'type' => $this->creator_user_type,
                    'name' => $name,
                    'phone'=>$phone
                ];
            }),
            'service_type' => new ServiceTypeResource($this->whenLoaded('serviceType')),
            'country' => new CountryResource($this->whenLoaded('country')),
            'governorate' => new GovernorateResource($this->whenLoaded('governorate')),
            'zone' => new ZoneResource($this->whenLoaded('zone')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'attributes' => ServiceAttributeResource::collection($this->whenLoaded('attributes')),

            'social_media' => $this->whenLoaded('socialMedia', function () {
                return $this->socialMedia->map(function ($sm) {
                    return [
                        'id' => $sm->id,
                        'name' => $sm->name,
                        'link' => $sm->pivot->link,
                    ];
                });
            }),
            'schedules' => ServiceScheduleResource::collection($this->whenLoaded('schedules')),
            // 'rates' => ServiceRateResource::collection($this->whenLoaded('rates')),
            'average_rating' => $this->averageRating(),

            'attachments' => ServiceAttachmentResource::collection($this->whenLoaded('attachments')),
        ];
    }
}
