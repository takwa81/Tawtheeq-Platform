<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Api\AttributeKeyRequest;
use App\Services\AttributeKeyService;
use App\Traits\ResultTrait;
use Exception;

class AttributeKeyController extends Controller
{
    use ResultTrait;
    protected AttributeKeyService $attributeKeyService;

    public function __construct(AttributeKeyService $attributeKeyService)
    {
        $this->attributeKeyService = $attributeKeyService;
    }

    public function index()
    {
        try {
            $user = currentUser();

            $attributeKeys = $this->attributeKeyService->getAttributeKeys($user);

            return $this->successResponse($attributeKeys);
        } catch (Exception $e) {
            $statusCode = is_int($e->getCode()) && $e->getCode() >= 100 ? $e->getCode() : 500;
            return $this->errorResponse($e->getMessage(), null, $statusCode);
        }
    }
    
    public function show($id)
    {
        try {
             $attributeKey = $this->attributeKeyService->getAttributeKey($id);

            return $this->successResponse($attributeKey);
        } catch (Exception $e) {
            $statusCode = is_int($e->getCode()) && $e->getCode() >= 100 ? $e->getCode() : 500;
            return $this->errorResponse($e->getMessage(), null, $statusCode);
        }
    }

    public function store(AttributeKeyRequest $request)
    {
        try {
            $data = $request->validated();

            $data['creator_user_id'] = currentUser()->dataEntry->id;
            $data['creator_user_type'] = get_class(currentUser()->dataEntry);

            $attributeKey = $this->attributeKeyService->createAttributeKey($data);

            return $this->successResponse($attributeKey, __('messages.attributeKey_created_success'));
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update(AttributeKeyRequest $request, $id)
    {
        try {
            $data = $request->validated();

            $attributeKey = $this->attributeKeyService->updateAttributeKey($id, $data);
            return $this->successResponse($attributeKey, __('messages.service_updated_success'));
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
           $attributeKey = $this->attributeKeyService->deleteAttributeKey($id);
            return $this->successResponse(null, __('messages.service_updated_success'));
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
    

}
