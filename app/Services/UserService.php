<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserService
{
    public function filterUsers(Request $request, ?string $userType = null, int $perPage = 15)
    {
        $query = User::query();



        if ($userType) {
            $query->where('role', $userType);
        }

        if ($userType == "branch_manager") {
            $query->with(['branchManager' => function ($q) {
                $q->withCount('branches');
            }]);

            $query->with(['branchManager' => function ($q) {
                $q->withCount('branches');
            }]);

            if ($request->filled('not_subscribed') && $request->not_subscribed) {
                $query->whereDoesntHave('activeSubscription');
            }

            if ($request->filled('package_id')) {
                $query->whereHas('activeSubscription', function ($q) use ($request) {
                    $q->where('package_id', $request->package_id);
                });
            }
        }

        if ($userType == "branch") {
            $query->with(['branch' => function ($q) {
                $q->withCount('orders');
            }]);

            $query->withCount(['branch as orders_count' => function ($q) {
                $q->join('orders', 'orders.branch_id', '=', 'branches.id');
            }]);
        }



        if (auth()->check() && auth()->user()->role === 'branch_manager' && $userType === 'branch') {
            $branchManager = auth()->user()->branchManager;

            if ($branchManager) {
                $query->whereHas('branch', function ($q) use ($branchManager) {
                    $q->where('manager_id', $branchManager->id);
                });
            } else {
                $query->whereRaw('1=0');
            }
        }

        if ($userType === 'branch' && $request->filled('creator_user_id')) {
            $query->whereHas('branch', function ($q) use ($request) {
                $q->where('creator_user_id', $request->creator_user_id);
            });
        }


        if ($request->filled('name')) {
            $query->where('full_name', 'like', '%' . $request->name . '%');
        }

        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->phone . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('only_trashed') && $request->only_trashed) {
            $query->onlyTrashed();
        }

        if ($request->filled('sort')) {
            $request->sort === 'latest' ? $query->latest() : $query->oldest();
        } else {
            $query->latest();
        }

        return $query->paginate($perPage)->appends($request->all());
    }

    public function createUser(array $data, string $userType, ?\Closure $extra = null)
    {
        return DB::transaction(function () use ($data, $userType, $extra) {
            $data['role'] = $userType;
            $data['status'] = $data['status'] ?? 'active';
            // $data['password'] = Hash::make($data['password']);
            if (!empty($data['password'])) {
                $data['password'] = Hash::make($data['password']);
            } else {
                unset($data['password']);
            }
            $user = User::create($data);

            if ($extra) {
                $extra($user);
            }

            $user->account_status_badge = accountStatusBadge($user->status);

            return $user;
        });
    }

    public function updateUser(User $user, array $data, ?\Closure $extra = null)
    {
        if (!empty($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        } else {
            unset($data['password']);
        }

        $user->update($data);

        if ($extra) {
            $extra($user);
        }

        $user->account_status_badge = accountStatusBadge($user->status);

        return $user;
    }

    public function deleteUser(User $user)
    {
        $user->status = 'deleted';
        $user->save();
        $user->delete();
        return $user;
    }

    public function restoreUser(User $user)
    {
        $user->status = 'active';
        $user->restore();
        return $user;
    }

    public function changeStatus(User $user, string $status)
    {
        $user->status = $status;
        $user->save();
        return $user;
    }
}