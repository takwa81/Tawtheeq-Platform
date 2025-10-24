<?php

namespace App\Interfaces;

use App\Models\ServiceSocialMedia;

interface ServiceSocialMediaRepositoryInterface
{
    public function updateOrCreateSocial(int $serviceId, array $data): ServiceSocialMedia;
}
