<?php

namespace App\Interfaces;

interface DefinitionRepositoryInterface
{
    public function getConfigs();
    public function getAllCountries();
    public function getAllGovernorates($id);
    public function getZonesByGovernorateId($governorateId);
    public function getAllSocialMedia();
    public function getAllServiceTypes();
    public function getAllTags();
    public function getAllAcademicQualifications();
    public function getTagByServiceType($id);
}
