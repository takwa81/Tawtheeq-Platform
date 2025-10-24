<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ServiceOwnerRequest;
use App\Http\Resources\ServiceOwnerResource;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;
use App\Traits\ImageHandler;
use App\Traits\ResultTrait;
use Exception;
use Illuminate\Http\Request;

class ServiceOwnerController extends Controller
{
    use ResultTrait, ImageHandler;
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getAllServiceOwners()
    {
        try {

            $serviceOwners = User::with(['serviceOwner.creator'])
                ->where('user_type', 'serviceOwner')
                ->latest()
                ->get();

            return $this->successResponse(UserResource::collection($serviceOwners));
        } catch (Exception $e) {
            $statusCode = is_int($e->getCode()) && $e->getCode() >= 100 ? $e->getCode() : 500;
            return $this->errorResponse($e->getMessage(), null, $statusCode);
        }
    }
    public function index()
    {
        try {
            $user = currentUser();

            $serviceOwners = User::with(['serviceOwner.creator'])
                ->where('user_type', 'serviceOwner')
                ->whereHas('serviceOwner', function ($query) use ($user) {
                    $query->where('creator_user_id', $user->id);
                })->latest()
                ->get();

            return $this->successResponse(UserResource::collection($serviceOwners));
        } catch (Exception $e) {
            $statusCode = is_int($e->getCode()) && $e->getCode() >= 100 ? $e->getCode() : 500;
            return $this->errorResponse($e->getMessage(), null, $statusCode);
        }
    }

    public function show($id)
    {
        try {
            $serviceOwnerUser = User::with([
                'serviceOwner.academicQualification',
                'serviceOwner.creator'
            ])
                ->where('user_type', 'serviceOwner')
                ->findOrFail($id);

            if (!$serviceOwnerUser->serviceOwner) {
                return $this->errorResponse(__('messages.service_owner_not_found'), null, 404);
            }

            return $this->successResponse(new UserResource($serviceOwnerUser));
        } catch (\Exception $e) {
            $statusCode = is_int($e->getCode()) && $e->getCode() >= 100 ? $e->getCode() : 500;
            return $this->errorResponse($e->getMessage(), null, $statusCode);
        }
    }

    public function store(ServiceOwnerRequest $request)
    {
        try {
            $data = $request->validated();
            $data['account_status'] = 'active';
            $user = $this->userService->createUser($data, 'serviceOwner', function ($user) use ($request, $data) {
                $imagePath = null;
                if ($request->hasFile('personal_image_path')) {
                    $imagePath = $this->storeImage($request->file('personal_image_path'), 'service_owners');
                }

                $user->serviceOwner()->create([
                    'user_id' => $user->id,
                    'creator_user_id' => auth()->user()->id,
                    'gender' => $data['gender'],
                    'academic_qualification_id' => $data['academic_qualification_id'] ?? null,
                    'age' => $data['age'] ?? null,
                    'email' => $data['email'] ?? null,
                    'personal_image_path' => $imagePath ?? null,
                    'data_entry_note' => $data['data_entry_note'],
                ]);
            });
            $user->load('serviceOwner.academicQualification', 'serviceOwner.creator');

            return $this->successResponse(new UserResource($user), __('messages.service_owner_created_success'));
        } catch (Exception $e) {
            $statusCode = is_int($e->getCode()) && $e->getCode() >= 100 ? $e->getCode() : 500;
            return $this->errorResponse($e->getMessage(), null, $statusCode);
        }
    }

    public function update(ServiceOwnerRequest $request, $id)
    {
        try {
            $user = User::where('user_type', 'serviceOwner')->findOrFail($id);
            $data = $request->validated();

            $this->userService->updateUser($user, $data);

            $serviceOwner = $user->serviceOwner;

            if ($serviceOwner->creator_user_id !== auth()->user()->id) {
                return $this->errorResponse(
                    __('messages.not_authorized_update_service_owner'),
                    null,
                    403
                );
            }

            $imagePath = $serviceOwner->personal_image_path;
            if ($request->hasFile('personal_image_path')) {
                $imagePath = $this->updateImage(
                    $request->file('personal_image_path'),
                    $serviceOwner->personal_image_path,
                    'service_owners'
                );
            }

            $serviceOwner->update([
                'gender' => $data['gender'] ?? $serviceOwner->gender,
                'academic_qualification_id' => $data['academic_qualification_id'] ?? $serviceOwner->academic_qualification_id,
                'age' => $data['age'] ?? $serviceOwner->age,
                'email' => $data['email'] ?? $serviceOwner->email,
                'personal_image_path' => $imagePath,
                'data_entry_note' => $data['data_entry_note'] ?? $serviceOwner->data_entry_note,
            ]);

            $user->load('serviceOwner.academicQualification', 'serviceOwner.creator');

            return $this->successResponse(
                new UserResource($user),
                __('messages.service_owner_updated_success')
            );
        } catch (Exception $e) {
            $statusCode = is_int($e->getCode()) && $e->getCode() >= 100 ? $e->getCode() : 500;
            return $this->errorResponse($e->getMessage(), null, $statusCode);
        }
    }
}
