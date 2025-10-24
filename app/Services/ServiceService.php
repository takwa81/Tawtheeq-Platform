<?php

namespace App\Services;

use App\Interfaces\ServiceRepositoryInterface;

class ServiceService
{
    protected ServiceRepositoryInterface $serviceRepo;

    public function __construct(ServiceRepositoryInterface $serviceRepo)
    {
        $this->serviceRepo = $serviceRepo;
    }

    public function getAllServices()
    {
        return $this->serviceRepo->allServices();
    }
    public function getAllMyServices()
    {
        return $this->serviceRepo->ownServices();
    }
    public function show($id){
        return $this->serviceRepo->serviceDetails($id);
    }
    public function createService(array $data)
    {
        return $this->serviceRepo->createService($data);
    }

    public function updateService(int $id, array $data)
    {
        return $this->serviceRepo->updateService($id, $data);
    }
}
