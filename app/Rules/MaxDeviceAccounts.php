<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class MaxDeviceAccounts implements Rule
{
    protected int $maxAllowed;
    protected string $message;

    public function __construct(int $maxAllowed = 3)
    {
        $this->maxAllowed = $maxAllowed;
    }

    public function passes($attribute, $value): bool
    {
        $count = DB::table('users')->where('device_id', $value)->count();

        if ($count >= $this->maxAllowed) {
            $this->message = __('messages.device_limit_reached', ['max' => $this->maxAllowed]);
            return false;
        }

        return true;
    }

    public function message(): string
    {
        return $this->message ?? 'Too many accounts registered on this device.';
    }
}
