<?php

namespace App\Repositories;

use App\Interfaces\ServiceSocialMediaRepositoryInterface;
use App\Models\ServiceSocialMedia;

class ServiceSocialMediaRepository implements ServiceSocialMediaRepositoryInterface
{
    public function updateOrCreateSocial(int $serviceId,array $data): ServiceSocialMedia
    {
        return ServiceSocialMedia::updateOrCreate(
            ['service_id' => $serviceId , 'social_media_id' => $data['social_media_id']],
            $data
        );
    }
}
