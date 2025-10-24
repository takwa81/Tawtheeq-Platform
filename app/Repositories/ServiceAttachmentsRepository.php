<?php

namespace App\Repositories;

use App\Interfaces\ServiceAttachmentsRepositoryInterface;
use App\Models\ServiceAttachment;

class ServiceAttachmentsRepository implements ServiceAttachmentsRepositoryInterface
{
    public function createAttachment(int $serviceId, array $data): ServiceAttachment
    {
        return ServiceAttachment::create(
            $data
        );
    }

    public function getAttachments(int $serviceId)
    {
        return ServiceAttachment::where('service_id', $serviceId)->get();
    }
    public function getById(int $id)
    {
        return ServiceAttachment::findOrFail($id);
    }

    public function delete($id)
    {
        return ServiceAttachment::destroy($id);
    }
    public function update(int $id, array $data): ServiceAttachment
    {
        $attachment = ServiceAttachment::findOrFail($id);
        $attachment->update($data);
        return $attachment;
    }
}
