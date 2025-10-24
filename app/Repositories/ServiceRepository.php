<?php

namespace App\Repositories;

use App\Enums\PaginationEnum;
use App\Http\Resources\ServiceResource;
use App\Interfaces\ServiceRepositoryInterface;
use App\Models\DataEntry;
use App\Models\Service;
use App\Models\ServiceSchedule;
use App\Models\User;

class ServiceRepository implements ServiceRepositoryInterface
{
    public function createService(array $data): Service
    {
        return Service::create($data);
    }
    public function updateService(int $id, array $data): Service
    {
        $service = Service::findOrFail($id);
        $service->update($data);
        return $service;
    }

    public function allServices()
    {
        return ServiceResource::collection(
            Service::with([
                'managingUser',
                'creatorUser',
                'serviceType',
                'subscription',
                'country',
                'governorate',
                'zone',
                'attributes',
                'tags',
                'socialMedia',
                'schedules',
                'rates',
                'attachments',
            ])->latest()->paginate(PaginationEnum::DefaultCount->value)
        );
    }

    public function ownServices()
    {
        $user = currentUser();

        return ServiceResource::collection(
            Service::with([
                'managingUser',
                'creatorUser',
                'serviceType',
                'subscription',
                'country',
                'governorate',
                'zone',
                'attributes',
                'tags',
                'socialMedia',
                'schedules',
                'rates',
                'attachments',
            ])
                ->where('creator_user_type', DataEntry::class)
                ->where('creator_user_id', $user->dataEntry->id)
                ->latest('updated_at')
                ->paginate(PaginationEnum::DefaultCount->value)
        );
    }

    public function serviceDetails($id)
    {
        $service = Service::with([
            'managingUser',
            'creatorUser',
            'serviceType',
            'subscription',
            'country',
            'governorate',
            'zone',
            'attributes',
            'tags',
            'socialMedia',
            'schedules',
            'rates',
            'attachments',
        ])->findOrFail($id);

        return new ServiceResource($service);
    }
}
