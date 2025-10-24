<?php

namespace App\Services;

use App\Interfaces\DefinitionRepositoryInterface;

class DefinitionService
{
    protected DefinitionRepositoryInterface $definitionRepo;

    public function __construct(DefinitionRepositoryInterface $definitionRepo)
    {
        $this->definitionRepo = $definitionRepo;
    }
    public function getAllGovernorates($id)
    {
        return $this->definitionRepo->getAllGovernorates($id);
    }

    public function getConfigs(){

        return $this->definitionRepo->getConfigs();
    }
    public function getAllCountries()
    {
        return $this->definitionRepo->getAllCountries();
    }
    public function getZonesByGovernorateId($id)
    {
        return $this->definitionRepo->getZonesByGovernorateId($id);
    }

    public function getAllSocialMedia()
    {
        return $this->definitionRepo->getAllSocialMedia();
    }

    public function getAllServiceTypes()
    {
        return $this->definitionRepo->getAllServiceTypes();
    }

    public function getAllTags()
    {
        return $this->definitionRepo->getAllTags();
    }

    public function getAllAcademicQualifications()
    {
        return $this->definitionRepo->getAllAcademicQualifications();
    }
    public function getTagByServiceType($id)
    {
        return $this->definitionRepo->getTagByServiceType($id);
    }
}
