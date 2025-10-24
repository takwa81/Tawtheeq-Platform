<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

trait FiltersListTrait
{
    public function applyNameFilterAndSorting(Request $request, Builder $query): Builder
    {
        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('name_en', 'like', '%' . $request->name . '%')
                    ->orWhere('name_ar', 'like', '%' . $request->name . '%');
            });
        }

        $sortDirection = $request->get('sort') === 'oldest' ? 'asc' : 'desc';
        return $query->orderBy('created_at', $sortDirection);
    }
    
    public function applyNameFilterAndSortingUser(Request $request, Builder $query): Builder
    {
        if ($request->filled('name')) {
            $query->where(function ($q) use ($request) {
                $q->where('full_name', 'like', '%' . $request->name . '%')
                    ->orWhere('phone_number', 'like', '%' . $request->name . '%');
            });
        }

        $sortDirection = $request->get('sort') === 'oldest' ? 'asc' : 'desc';
        return $query->orderBy('created_at', $sortDirection);
    }
}
