<?php

namespace App\Interfaces;

use App\Models\User;

interface UserInterface
{
    public function findByPhone(string $phone): ?User;
    public function incrementFailedLogin(User $user): void;
    public function resetFailedLogin(User $user): void;
}
