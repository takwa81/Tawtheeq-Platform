<?php

namespace App\Services;

use App\Interfaces\ServiceAttachmentsRepositoryInterface;
use Exception;
use App\Traits\UploadHandler;

class ServiceAttachmentService
{
    use UploadHandler;
    protected ServiceAttachmentsRepositoryInterface $serviceAttachment;

    public function __construct(ServiceAttachmentsRepositoryInterface $serviceAttachment)
    {
        $this->serviceAttachment = $serviceAttachment;
    }

    public function addAttachment(int $serviceId, array $data)
    {
        $attachment = [];

        $attachment['service_id'] = $serviceId;
        $attachment['attachment_type'] = $this->getAttachmentType($data);
        $attachment['path_to_attachment'] = $this->storeFile($data['attachment'], 'service_attachments');
        return $this->serviceAttachment->createAttachment($serviceId, $attachment);
    }
    public function getAttachmentType(array $data)
    {

        if ($data['isPanorama']) {
            return '360';
        }
        $imageExtensions = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'bmp', 'tiff', 'heic', 'heif'];
        $videoExtensions = ['mp4', 'mov', 'avi', 'mkv', 'webm', 'flv', 'wmv', 'mpeg', 'mpg'];
        $extension = strtolower($data['attachment']->getClientOriginalExtension());

        if (in_array($extension, $imageExtensions)) {
            return 'image';
        } elseif (in_array($extension, $videoExtensions)) {
            return 'video';
        }
        throw new Exception(__('messages.extention_unsupported') . $extension);
    }

    public function getServiceAttachments(int $serviceId)
    {
        return $this->serviceAttachment->getAttachments($serviceId);
    }

    public function getAttachment($id)
    {
        return $this->serviceAttachment->getById($id);
    }


    public function deleteAttachment(int $id)
    {
        $attachment = $this->serviceAttachment->getById($id);
        if ($attachment) {
            $this->deleteFile($attachment->path_to_attachment, 'service_attachments');
            return $this->serviceAttachment->delete($id);
        }
        throw new Exception(__('messages.attachment_not_found'));
    }
    public function updateAttachment(int $id, array $data)
    {
        $attachment = $this->serviceAttachment->getById($id);

        if ($attachment) {
            return $this->serviceAttachment->update($id, [
                'attachment_type' => $this->getAttachmentType($data),
                'path_to_attachment' => $this->updateFile($data['attachment'], $attachment->path_to_attachment, 'service_attachments'),
            ]);
        }
        throw new Exception(__('messages.attachment_not_found'));
    }
}
