<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ServiceSocialMediaRequest;
use App\Services\ServiceSocialMediaService;
use App\Traits\ResultTrait;
use Illuminate\Http\Request;

class ServiceSocialMediaController extends Controller
{
    use ResultTrait ;

     protected ServiceSocialMediaService $serviceSocialMediaService;

    public function __construct(ServiceSocialMediaService $serviceSocialMediaService)
    {
        $this->serviceSocialMediaService = $serviceSocialMediaService;
    }


    public function save(ServiceSocialMediaRequest $request, $serviceId)
    {
        try {
            if(!empty($request->social_media)){

                $socialMedias = $request->validated()['social_media'];
            }
            $socialMedias = [];
            $result = $this->serviceSocialMediaService->saveSocialMedias($serviceId, $socialMedias);

            return $this->successResponse($result, __('messages.service_social_saved_success'));
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
