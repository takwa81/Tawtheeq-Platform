<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class NoOverlappingTimes implements Rule
{
    public function passes($attribute, $value)
    {
        $times = collect($value);
        $times = $times->sortBy('start_time');

        for ($i = 0; $i < $times->count() - 1; $i++) {
            $currentStart = $times[$i]['start_time'];
            $currentEnd = $times[$i]['end_time'];
            $nextStart = $times[$i + 1]['start_time'];
            $nextEnd = $times[$i + 1]['end_time'];

            if ($currentEnd > $nextStart) {
                return false;
            }
        }

        return true;
    }

    public function message()
    {
        return __('messages.times_overlap');
    }
}
