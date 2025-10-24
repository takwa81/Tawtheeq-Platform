<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ServiceAttachmentService;
use App\Http\Requests\Api\ServiceAttachmentRequest;
use App\Traits\ResultTrait;

class ServiceAttachmentController extends Controller
{
    use ResultTrait;

    protected ServiceAttachmentService $serviceAttachmentService;

    public function __construct(ServiceAttachmentService $serviceAttachmentService)
    {
        $this->serviceAttachmentService = $serviceAttachmentService;
    }

    public function store(ServiceAttachmentRequest $request, $serviceId)
    {
        try {
            $data = $request->validated();

            $serviceAttachment = $this->serviceAttachmentService->addAttachment($serviceId , $data);

            return $this->successResponse($serviceAttachment, __('messages.service_attachment_created_success'));
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }


    public function getServiceAttachments($serviceId){
        try {
            $serviceAttachments = $this->serviceAttachmentService->getServiceAttachments($serviceId);

            return $this->successResponse($serviceAttachments, __('messages.service_attachments_fetched_success'));
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function show($attachmentId){
        try {
            $serviceAttachment = $this->serviceAttachmentService->getAttachment($attachmentId);

            return $this->successResponse($serviceAttachment, __('messages.service_attachment_fetched_success'));
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function delete($attachmentId){
        try {
            $serviceAttachment = $this->serviceAttachmentService->deleteAttachment($attachmentId);

            return $this->successResponse(null, __('messages.service_attachment_deleted_success'));
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function update(ServiceAttachmentRequest $request, $attachmentId){
        try {
            $data = $request->validated();

            $serviceAttachment = $this->serviceAttachmentService->updateAttachment($attachmentId, $data);

            return $this->successResponse($serviceAttachment, __('messages.service_attachment_updated_success'));
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

}
