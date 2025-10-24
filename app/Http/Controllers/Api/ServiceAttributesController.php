<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ServiceAttributeService;
use App\Http\Requests\Api\ServiceAttributeRequest;
use App\Traits\ResultTrait;
use Illuminate\Http\Request;

class ServiceAttributesController extends Controller
{
    use ResultTrait;
    protected ServiceAttributeService $serviceAttributeService;

    public function __construct(ServiceAttributeService $serviceAttributeService)
    {
        $this->serviceAttributeService = $serviceAttributeService;
    }

    public function save(ServiceAttributeRequest $request, $serviceId)
    {
        try {
            $attributesKey = $request->validated()['attributes'];

            $result = $this->serviceAttributeService->saveServiceAttributes($serviceId, $attributesKey);

            return $this->successResponse($result, __('messages.attributes_added_success'));
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
