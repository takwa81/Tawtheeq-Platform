<?php

namespace App\Services;

use App\Interfaces\ServiceOwnerAttributesRepositoryInterface;
use App\Models\ServiceOwner;
use App\Models\AttributeKey;

class ServiceOwnerAttributeService
{
    protected ServiceOwnerAttributesRepositoryInterface $serviceOwnerAttributeRepo;

    public function __construct(ServiceOwnerAttributesRepositoryInterface $serviceOwnerAttributeRepo)
    {
        $this->serviceOwnerAttributeRepo = $serviceOwnerAttributeRepo;
    }

    public function saveServiceAttributes(int $serviceOwnerId, array $attributes)
    {
        $result = [];
        $serviceOwner = ServiceOwner::findOrFail($serviceOwnerId);
        $serviceOwner?->attributes()->delete();

        foreach ($attributes as $item) {
            $item['service_owner_id'] = $serviceOwnerId;
            $result[] = $this->serviceOwnerAttributeRepo->createServiceOwnerAttribute($serviceOwnerId,$item);
        }

        return $result;
    }
}

