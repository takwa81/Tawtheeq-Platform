<?php

namespace App\Repositories;

use App\Http\Resources\TagResource;
use App\Interfaces\DefinitionRepositoryInterface;
use App\Models\AcademicQualification;
use App\Models\Config;
use App\Models\Country;
use App\Models\Governorate;
use App\Models\ServiceType;
use App\Models\SocialMedia;
use App\Models\Tag;
use App\Models\Zone;

class DefinitionRepository implements DefinitionRepositoryInterface
{
    public function getConfigs()
    {
        return Config::select('version_app')->first();
    }
    public function getAllCountries()
    {
        return Country::all();
    }
    public function getAllGovernorates($id)
    {
        return Governorate::withCount('zones')->where('country_id', $id)->get();
    }

    public function getZonesByGovernorateId($governorateId)
    {
        return Zone::where('governorate_id', $governorateId)->get();
    }

    public function getAllSocialMedia()
    {
        return SocialMedia::all();
    }

    public function getAllServiceTypes()
    {
        return ServiceType::all();
    }

    public function getAllTags()
    {
        return Tag::all();
    }
    public function getAllAcademicQualifications()
    {
        return AcademicQualification::all();
    }

    public function getTagByServiceType($id)
    {
        $serviceType = ServiceType::with('tags')->find($id);
        $tags = $serviceType->tags;
        return TagResource::collection($tags);
    }
}
