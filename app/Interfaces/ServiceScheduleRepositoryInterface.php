<?php

namespace App\Interfaces;

use App\Models\ServiceSchedule;

interface ServiceScheduleRepositoryInterface
{
    public function updateOrCreateSchedule(int $serviceId, string $day, array $data): ServiceSchedule;
}
