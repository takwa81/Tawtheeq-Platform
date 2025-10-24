<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ServiceScheduleRequest;
use App\Http\Requests\Api\StoreOrUpdateServiceScheduleRequest;
use App\Services\ServiceScheduleService;
use App\Traits\ResultTrait;

class ServiceScheduleController extends Controller
{
    use ResultTrait;

    protected ServiceScheduleService $serviceScheduleService;

    public function __construct(ServiceScheduleService $serviceScheduleService)
    {
        $this->serviceScheduleService = $serviceScheduleService;
    }

    public function save(ServiceScheduleRequest $request, $serviceId)
    {
        try {
            $schedules = $request->validated()['schedules'];

            $result = $this->serviceScheduleService->saveSchedules($serviceId, $schedules);

            return $this->successResponse($result, __('messages.service_schedule_saved_success'));
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
