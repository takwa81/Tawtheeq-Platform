<?php

namespace App\Repositories;

use App\Interfaces\ServiceScheduleRepositoryInterface;
use App\Models\ServiceSchedule;

class ServiceScheduleRepository implements ServiceScheduleRepositoryInterface
{
    public function updateOrCreateSchedule(int $serviceId, string $day, array $data): ServiceSchedule
    {
        return ServiceSchedule::updateOrCreate(
            ['service_id' => $serviceId, 'day' => $day],
            $data
        );
    }
}
