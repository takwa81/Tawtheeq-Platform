<?php

namespace App\Interfaces;

use App\Models\ServiceAttribute;

interface ServiceAttributeRepositoryInterface
{
    // public function AddServiceAttribute(int $serviceId, array $data): ServiceAttribute;
    // public function editServiceAttribute(int $serviceId, array $data): ServiceAttribute;
    public function createServiceAttribute(int $serviceId, array $data): ServiceAttribute;
    // public function deleteServiceAttribute(int $id): ServiceAttribute;
}
