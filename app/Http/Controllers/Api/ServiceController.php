<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\StoreServiceRequest;
use App\Http\Requests\Api\UpdateServiceRequest;
use App\Http\Requests\Api\UpdateServiceScheduleRequest;
use App\Services\ServiceService;
use App\Traits\ResultTrait;

class ServiceController extends Controller
{
    use ResultTrait;

    protected ServiceService $serviceService;

    public function __construct(ServiceService $serviceService)
    {
        $this->serviceService = $serviceService;
    }

    public function getAllServices()
    {
        try {
            
            $services = $this->serviceService->getAllServices();

            return $this->successResponse($services);
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    public function index()
    {
       try {
            
            $service = $this->serviceService->getAllMyServices();

            return $this->successResponse($service);
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function show($id){
         try {
            
            $service = $this->serviceService->show($id);

            return $this->successResponse($service);
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function store(StoreServiceRequest $request)
    {
        try {
            $data = $request->validated();
            
            $data['creator_user_id'] = currentUser()->dataEntry->id;
            $data['creator_user_type'] = get_class(currentUser()->dataEntry);

            $service = $this->serviceService->createService($data);

            return $this->successResponse($service, __('messages.service_created_success'));
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update(UpdateServiceRequest $request, $id)
    {
        try {
            $data = $request->validated();

            $service = $this->serviceService->updateService($id, $data);

            if (isset($data['tags'])) {
                $service->tags()->sync($data['tags']);
            }

            return $this->successResponse($service, __('messages.service_updated_success'));
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
