<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ChangePasswordRequest;
use App\Http\Requests\Api\LoginRequest;
use App\Services\AuthService;
use App\Traits\ResultTrait;
use Exception;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    use ResultTrait;
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
    }

    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $data = $this->authService->login($request);
            return $this->successResponse($data, __('messages.login_success'));
        } catch (Exception $e) {
            $statusCode = is_int($e->getCode()) && $e->getCode() >= 100 ? $e->getCode() : 500;
            return $this->errorResponse($e->getMessage(), null, $statusCode);
        }
    }

    public function profile()
    {
        try {
            $user = currentUser();
            if (!$user) {
                return $this->errorResponse(__('messages.not_found'), null, 404);
            }

            $data = $this->authService->getProfile($user);

            return $this->successResponse($data);
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), null, 500);
        }
    }

    public function logout(): JsonResponse
    {
        try {
            $user = currentUser();
            if (!$user) {
                return $this->errorResponse(__('messages.not_authenticated'), null, 401);
            }

            $this->authService->logout($user);

            return $this->successResponse(null, __('messages.logout_success'));
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), null, $e->getCode() ?: 500);
        }
    }

    public function changePassword(ChangePasswordRequest $request)
    {
        try {
            $user = currentUser();

            $this->authService->changePassword($user, $request->only([
                'current_password',
                'new_password',
            ]));

            return $this->successResponse(null, __('messages.password_changed_success'));
        } catch (Exception $e) {
            return $this->errorResponse($e->getMessage(), null, $e->getCode() ?: 500);
        }
    }
}
