<?php

namespace App\Repositories;

use App\Interfaces\ServiceOwnerAttributesRepositoryInterface;
use App\Models\ServiceOwnerAttributes;

class ServiceOwnerAttributesRepository implements ServiceOwnerAttributesRepositoryInterface
{
    public function createServiceOwnerAttribute(int $serviceOwnerId, array $data): ServiceOwnerAttributes{
         return ServiceOwnerAttributes::updateOrCreate(
            ['service_owner_id' => $serviceOwnerId , 'attribute_key_id' => $data['attribute_key_id']],
            $data
        );
    }
    // public function deleteServiceAttribute(int $id): ServiceAttribute{
    //     $serviceAttribute = ServiceAttribute::findOrFail($id);
    //     $serviceAttribute->delete();
    //     return $serviceAttribute;
    // }
}
