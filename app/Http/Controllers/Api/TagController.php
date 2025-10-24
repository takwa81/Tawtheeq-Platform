<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TagRequest;
use App\Services\TagService;
use App\Traits\ResultTrait;
use Illuminate\Http\Request;

class TagController extends Controller
{
    use ResultTrait;
    protected $tagService;
    public function __construct(TagService $tagService)
    {
        $this->tagService = $tagService;
    }
    public function store(TagRequest $request)
    {
        try {
            $data = $request->validated();

            $service = $this->tagService->createTag($data);

            return $this->successResponse($service, __('messages.tag_created_success'));
        } catch (\Throwable $e) {
            return $this->errorResponse($e->getMessage());
        }
    }
}
