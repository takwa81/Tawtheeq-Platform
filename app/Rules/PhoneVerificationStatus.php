<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class PhoneVerificationStatus implements Rule
{
    protected string $userType;
    protected string $message = 'Validation failed.';

    public function __construct(string $userType)
    {
        $this->userType = $userType;
    }

    public function passes($attribute, $value): bool
    {
        $user = DB::table('users')
            ->where('phone_number', $value)
            ->where('user_type', $this->userType)
            ->first();

        if (!$user) {
            return true;
        }

        if ($user->is_verify) {
            $this->message = __('messages.account_already_verified');
            return false;
        }

        if (!$user->is_verify && $user->verify_code_expired_at && now()->lessThan($user->verify_code_expired_at)) {
            $this->message = __('messages.verification_pending');
            return false;
        }

        return true;
    }

    public function message(): string
    {
        return $this->message;
    }
}
