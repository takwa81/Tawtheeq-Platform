<?php

namespace App\Services;

use App\Interfaces\ServiceSocialMediaRepositoryInterface;

class ServiceSocialMediaService
{
    protected ServiceSocialMediaRepositoryInterface $serviceSocialMediaRepo;

    public function __construct(ServiceSocialMediaRepositoryInterface $serviceSocialMediaRepo)
    {
        $this->serviceSocialMediaRepo = $serviceSocialMediaRepo;
    }

    public function saveSocialMedias(int $serviceId, array $socialMedias)
    {
        $result = [];

        foreach ($socialMedias as $item) {
            $item['service_id'] = $serviceId;
            $result[] = $this->serviceSocialMediaRepo->updateOrCreateSocial($serviceId,$item);
        }

        return $result;
    }
}
