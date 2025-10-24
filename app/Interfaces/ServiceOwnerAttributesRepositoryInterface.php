<?php

namespace App\Interfaces;

use App\Models\ServiceOwnerAttributes;

interface ServiceOwnerAttributesRepositoryInterface
{
    // public function AddServiceAttribute(int $serviceId, array $data): ServiceAttribute;
    // public function editServiceAttribute(int $serviceId, array $data): ServiceAttribute;
    public function createServiceOwnerAttribute(int $serviceId, array $data): ServiceOwnerAttributes;
    // public function deleteServiceAttribute(int $id): ServiceAttribute;
}
