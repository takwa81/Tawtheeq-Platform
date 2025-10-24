<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GovernorateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
         return [
            'id'       => $this->id,
            'name_en'  => $this->name_en,
            'name_ar'  => $this->name_ar,
            'country'  => new CountryResource($this->whenLoaded('country')),
            'zones'    => ZoneResource::collection($this->whenLoaded('zones')),
        ];
    }
}
