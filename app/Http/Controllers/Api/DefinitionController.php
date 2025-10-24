<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SocialMediaResource;
use App\Services\DefinitionService;
use App\Traits\ResultTrait;
use Illuminate\Http\Request;

class DefinitionController extends Controller
{
    use ResultTrait;

    protected DefinitionService $definitionService;

    public function __construct(DefinitionService $definitionService)
    {
        $this->definitionService = $definitionService;
    }



    public function configs()
    {
        try {
            $data = $this->definitionService->getConfigs();
            return $this->successResponse($data);
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }


    public function countries()
    {
        try {
            $data = $this->definitionService->getAllCountries();
            return $this->successResponse($data);
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }


    public function governorates($id)
    {
        try {
            $data = $this->definitionService->getAllGovernorates($id);
            return $this->successResponse($data);
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function zones($governorateId)
    {
        try {
            $data = $this->definitionService->getZonesByGovernorateId($governorateId);
            return $this->successResponse($data);
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function socialMedia()
    {
        try {
            $data = $this->definitionService->getAllSocialMedia();
            return $this->successResponse(SocialMediaResource::collection($data));
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function serviceTypes()
    {
        try {
            $data = $this->definitionService->getAllServiceTypes();
            return $this->successResponse($data);
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function tags()
    {
        try {
            $data = $this->definitionService->getAllTags();
            return $this->successResponse($data);
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

    public function academicQualifications(){
           try {
            $data = $this->definitionService->getAllAcademicQualifications();
            return $this->successResponse($data);
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }


    public function getTagByServiceType($id)
    {
        try {
            $data = $this->definitionService->getTagByServiceType($id);
            return $this->successResponse($data);
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }

}
