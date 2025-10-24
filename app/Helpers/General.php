<?php

use App\Enums\DayEnum;
use Illuminate\Support\Facades\Auth;

if (!function_exists('currentUser')) {
    function currentUser()
    {
        return Auth::user();
    }
}

if (!function_exists('currentUserType')) {
    function currentUserType(): ?string
    {
        $user = currentUser();
        return $user ? $user->user_type : null;
    }
}


function dayAr(DayEnum $day): string {
    return match($day) {
        DayEnum::Saturday => 'السبت',
        DayEnum::Sunday => 'الأحد',
        DayEnum::Monday => 'الاثنين',
        DayEnum::Tuesday => 'الثلاثاء',
        DayEnum::Wednesday => 'الأربعاء',
        DayEnum::Thursday => 'الخميس',
        DayEnum::Friday => 'الجمعة',
    };
}

if (!function_exists('userTypeAr')) {
    function userTypeAr(string $userClass): string
    {
        return match($userClass) {
            \App\Models\Employee::class => 'الموظف',
            \App\Models\DataEntry::class => 'مسؤول إدخال البيانات',
            default => 'مستخدم',
        };
    }
}

