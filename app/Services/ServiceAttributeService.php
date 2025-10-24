<?php

namespace App\Services;

use App\Interfaces\ServiceAttributeRepositoryInterface;
use App\Models\Service;
use App\Models\AttributeKey;

class ServiceAttributeService
{
    protected ServiceAttributeRepositoryInterface $serviceAttributeRepo;

    public function __construct(ServiceAttributeRepositoryInterface $serviceAttributeRepo)
    {
        $this->serviceAttributeRepo = $serviceAttributeRepo;
    }

    public function saveServiceAttributes(int $serviceId, array $attributes)
    {
        $result = [];
        $service = Service::findOrFail($serviceId);
        $service?->attributes()->delete();

        foreach ($attributes as $item) {
            $item['service_id'] = $serviceId;
            $result[] = $this->serviceAttributeRepo->createServiceAttribute($serviceId,$item);
        }

        return $result;
    }
}
