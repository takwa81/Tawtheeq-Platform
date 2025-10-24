<?php

namespace App\Repositories;

use App\Models\User;
use App\Interfaces\UserInterface;

class UserRepository implements UserInterface
{
    public function findByPhone(string $phone): ?User
    {
        return User::where('phone_number', $phone)->first();
    }

    public function incrementFailedLogin(User $user): void
    {
        $user->increment('failed_login_attempts');
    }

    public function resetFailedLogin(User $user): void
    {
        $user->update(['failed_login_attempts' => 0]);
    }
}
