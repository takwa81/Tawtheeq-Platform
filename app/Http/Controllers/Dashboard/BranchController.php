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


    public function show(Request $request, $id)
    {
        try {
            $branch = User::where('role', 'branch')
                ->with(['branch.manager.user', 'branch.orders.company', 'branch.orders.creator'])
                ->withTrashed()
                ->findOrFail($id);

            $orders = $branch->branch->orders()->with('company')
                ->orderBy('created_at', 'desc')
                ->paginate(PaginationEnum::DefaultCount->value);

            $ordersCount = $branch->branch->orders()->count();
            $ordersTotal = $branch->branch->orders()->sum('total_order');

            $year = $request->year ?? now()->year;

            $months = range(1, 12);
            $ordersByMonthCount = [];
            $ordersByMonthTotal = [];

            foreach ($months as $month) {
                $monthlyOrders = $branch->branch->orders()
                    ->whereYear('created_at', $year)
                    ->whereMonth('created_at', $month);

                $ordersByMonthCount[] = $monthlyOrders->count();
                $ordersByMonthTotal[] = $monthlyOrders->sum('total_order');
            }

            $activeTab = $request->tab ?? 'info';

            return view('dashboard.branches.show', compact(
                'branch',
                'orders',
                'ordersCount',
                'ordersTotal',
                'year',
                'ordersByMonthCount',
                'ordersByMonthTotal',
                'activeTab'

            ));
        } catch (\Throwable $e) {
            toastr()->error(__('messages.fetch_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }


    public function store(UserRequest $request)
    {
        try {

            $data = $request->validated();
            // $branchManager = BranchManager::where('user_id', $data['manager_id'])->firstOrFail();
            if (auth()->user()->role === 'branch_manager') {
                $manager = BranchManager::where('user_id', auth()->user()->id)->firstOrFail();
            } else {
                $manager = BranchManager::where('user_id', $data['manager_id'])->firstOrFail();
            }

            $activeSub = $manager->user->activeSubscription;

            if (!$activeSub) {
                return response()->json([
                    'status' => false,
                    'message' => __('dashboard.manager_no_active_subscription')
                ], 422);
            }

            $currentBranchesCount = $manager->branches()->count();
            $branchesLimit = $activeSub->package->branches_limit;


            if ($currentBranchesCount >= $branchesLimit) {
                return response()->json([
                    'status' => false,
                    'message' => __('dashboard.manager_branch_limit_reached', ['limit' => $branchesLimit])
                ], 422);
            }

            $user = $this->userService->createUser($data, 'branch');

            $branch = $user->branch()->create([
                'user_id' => $user->id,
                'creator_user_id' => auth()->user()->id,
                'manager_id' => $manager->id,
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

            // return response()->json(['status' => true, 'message' => __('messages.user_activated_successfully'), 'data' => $user]);
            return response()->json([
                'status' => true,
                'message' => __('messages.user_activated_successfully'),
                'data' => [
                    'id' => $user->id,
                    'toggle_url' => route('dashboard.branches.deactivate', $user->id),
                ],
            ]);
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

            // return response()->json(['status' => true, 'message' => __('messages.user_deactivated_successfully'), 'data' => $user]);
            return response()->json([
                'status' => true,
                'message' => __('messages.user_deactivated_successfully'),
                'data' => [
                    'id' => $user->id,
                    'toggle_url' => route('dashboard.branches.activate', $user->id),
                ],
            ]);
        } catch (\Throwable $e) {
            toastr()->error(__('messages.update_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
