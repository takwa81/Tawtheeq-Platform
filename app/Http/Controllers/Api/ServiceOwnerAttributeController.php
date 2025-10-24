<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ServiceOwnerAttributeService;
use App\Http\Requests\Api\ServiceAttributeRequest;
use App\Traits\ResultTrait;
use Illuminate\Http\Request;

class ServiceOwnerAttributeController extends Controller
{
     use ResultTrait;
    protected ServiceOwnerAttributeService $serviceOwnerAttributeService;

    public function __construct(ServiceOwnerAttributeService $serviceOwnerAttributeService)
    {
        $this->serviceOwnerAttributeService = $serviceOwnerAttributeService;
    }

    public function save(ServiceAttributeRequest $request, $serviceOwnerId)
    {
        try {
            $attributesKey = $request->validated()['attributes'];

            $result = $this->serviceOwnerAttributeService->saveServiceAttributes($serviceOwnerId, $attributesKey);

            return $this->successResponse($result, __('messages.attributes_added_success'));
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
