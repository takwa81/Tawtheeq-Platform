<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRequest;
use App\Models\BranchManager;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        try {
            $branches = $this->userService->filterUsers($request, 'branch', PaginationEnum::DefaultCount->value);
            $managers = User::where('role', 'branch_manager')->where('status', 'active')->get();
            $branchManagers = BranchManager::with('user')->get();
            return view('dashboard.branches.index', compact('branches', 'managers', 'branchManagers'));
        } catch (\Throwable $e) {
            toastr()->error(__('messages.fetch_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        try {
            $branch = User::where('role', 'branch')
                ->with(['branch.manager.user', 'branch.orders.company', 'branch.orders.creator'])
                ->withTrashed()
                ->findOrFail($id);

            $ordersCount = $branch->branch->orders->count();
            $ordersTotal = $branch->branch->orders->sum('total_order');
            return view('dashboard.branches.show', compact('branch', 'ordersCount', 'ordersTotal'));
        } catch (\Throwable $e) {
            toastr()->error(__('messages.fetch_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }


    public function store(UserRequest $request)
    {
        try {

            $data = $request->validated();
            $user = $this->userService->createUser($data, 'branch');
            // $branchManager = BranchManager::where('user_id', $data['manager_id'])->firstOrFail();
            if (auth()->user()->role === 'branch_manager') {
                $managerId = BranchManager::where('user_id', auth()->user()->id)->firstOrFail()->id;
            } else {
                $managerId = BranchManager::where('user_id', $data['manager_id'])->firstOrFail()->id;
            }

            $branch = $user->branch()->create([
                'user_id' => $user->id,
                'creator_user_id' => auth()->user()->id,
                'manager_id' => $managerId,
                'branch_number' => $request->branch_number
            ]);

            $user->count_orders = $branch->orders()->count();
            $user->manager_name = $user->branch->manager?->user?->full_name ?? '-';
            $user->branch_number = $user->branch->branch_number ?? '-';


            return response()->json(['message' => __('messages.added_successfully'), 'data' => $user], 200);
        } catch (\Throwable $e) {
            toastr()->error(__('messages.add_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::where('role', 'branch')->findOrFail($id);
            $data = $request->validated();

            $this->userService->updateUser($user, $data);
            if ($user->branch) {
                $user->branch->update([
                    'branch_number' => $request->branch_number ?? $user->branch->branch_number,
                ]);
            }
            $user->count_orders = $user->branch ? $user->branch->orders()->count() : 0;
            $user->manager_name = $user->branch->manager?->user?->full_name ?? '-';
            $user->branch_number = $user->branch->branch_number ?? '-';

            return response()->json(['message' => __('messages.updated_successfully'), 'data' => $user], 200);
        } catch (\Throwable $e) {
            toastr()->error(__('messages.update_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::where('role', 'branch')->findOrFail($id);
            $this->userService->deleteUser($user);

            return response()->json(['status' => true, 'message' => __('messages.deleted_successfully')]);
        } catch (\Throwable $e) {
            toastr()->error(__('messages.delete_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function restore($id)
    {
        try {
            $user = User::where('role', 'branch')->onlyTrashed()->findOrFail($id);
            $this->userService->restoreUser($user);

            toastr()->success(__('messages.restored_successfully'));
            return redirect()->route('dashboard.branches.index');
        } catch (\Throwable $e) {
            toastr()->error(__('messages.restore_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function activate($id)
    {
        try {
            $user = User::where('role', 'branch')->findOrFail($id);
            $this->userService->changeStatus($user, 'active');

            return response()->json(['status' => true, 'message' => __('messages.user_activated_successfully'), 'data' => $user]);
        } catch (\Throwable $e) {
            toastr()->error(__('messages.update_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function deactivate($id)
    {
        try {
            $user = User::where('role', 'branch')->findOrFail($id);
            $this->userService->changeStatus($user, 'inactive');

            return response()->json(['status' => true, 'message' => __('messages.user_deactivated_successfully'), 'data' => $user]);
        } catch (\Throwable $e) {
            toastr()->error(__('messages.update_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
