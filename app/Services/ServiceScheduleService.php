<?php

namespace App\Services;

use App\Interfaces\ServiceScheduleRepositoryInterface;

class ServiceScheduleService
{
    protected ServiceScheduleRepositoryInterface $scheduleRepo;

    public function __construct(ServiceScheduleRepositoryInterface $scheduleRepo)
    {
        $this->scheduleRepo = $scheduleRepo;
    }

    public function saveSchedules(int $serviceId, array $schedules)
    {
        $result = [];

        foreach ($schedules as $item) {
            $item['service_id'] = $serviceId;

            $result[] = $this->scheduleRepo->updateOrCreateSchedule($serviceId, $item['day'], $item);
        }

        return $result;
    }
}
