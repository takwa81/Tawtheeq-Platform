<?php

namespace App\Interfaces;

use App\Models\Service;
use App\Models\ServiceSchedule;

interface ServiceRepositoryInterface
{
    public function createService(array $data): Service;
    public function updateService(int $id,array $data): Service;
    public function allServices();
    public function ownServices();
    public function serviceDetails($id);

}
