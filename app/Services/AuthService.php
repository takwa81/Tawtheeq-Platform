<?php

namespace App\Services;

use App\Http\Requests\Api\LoginRequest;
use App\Http\Resources\UserResource;
use App\Interfaces\UserInterface;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Hash;

class AuthService
{
    protected $userRepo;

    public function __construct(UserInterface $userRepo)
    {
        $this->userRepo = $userRepo;
    }

    public function login(LoginRequest $request): array
    {
        $user = $this->userRepo->findByPhone($request->phone_number);
        if (!$user) {
            throw new Exception(__('messages.invalid_credentials'), 401);
        }

        if ($user->account_status !== 'active') {
            throw new Exception(__('messages.account_not_active'), 403);
        }

        if (!Hash::check($request->password, $user->password)) {
            $this->userRepo->incrementFailedLogin($user);

            if ($user->failed_login_attempts + 1 >= 5) {
                throw new Exception(__('messages.contact_support'), 429);
            }

            throw new Exception(__('messages.invalid_credentials'), 401);
        }

        $this->userRepo->resetFailedLogin($user);

        if ($request->device_code) {
            $user->update(['device_code' => $request->device_code]);
        }

        $token = $user->createToken('api-token')->plainTextToken;

        return [
            'token' => $token,
            'user' => $user,
        ];
    }

    public function getProfile(User $user): array
    {
        if ($user->user_type === 'serviceOwner') {
            $user->load('serviceOwner.creator');
        }

        return (new UserResource($user))->toArray(request());
    }

    public function logout(User $user): void
    {
        $user->currentAccessToken()->delete();
    }

    public function changePassword(User $user, array $data): void
    {
        if (!Hash::check($data['current_password'], $user->password)) {
            throw new Exception(__('messages.password_incorrect'), 422);
        }

        $user->update([
            'password' => Hash::make($data['new_password']),
        ]);
    }
}
