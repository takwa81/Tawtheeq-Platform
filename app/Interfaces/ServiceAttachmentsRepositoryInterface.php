<?php

namespace App\Interfaces;

use App\Models\ServiceAttachment;

interface ServiceAttachmentsRepositoryInterface
{
    public function createAttachment(int $serviceId, array $data): ServiceAttachment;
    public function getAttachments(int $serviceId);
    public function getById(int $id);
    public function delete(int $id);
    public function update(int $id, array $data): ServiceAttachment;

}
