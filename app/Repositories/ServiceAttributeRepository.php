<?php

namespace App\Repositories;

use App\Interfaces\ServiceAttributeRepositoryInterface;
use App\Models\ServiceAttribute;

class ServiceAttributeRepository implements ServiceAttributeRepositoryInterface
{
    public function createServiceAttribute(int $serviceId, array $data): ServiceAttribute{
         return ServiceAttribute::updateOrCreate(
            ['service_id' => $serviceId , 'attribute_key_id' => $data['attribute_key_id']],
            $data
        );
    }
    // public function deleteServiceAttribute(int $id): ServiceAttribute{
    //     $serviceAttribute = ServiceAttribute::findOrFail($id);
    //     $serviceAttribute->delete();
    //     return $serviceAttribute;
    // }
}
