<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRequest;
use App\Models\SubscriptionPackage;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class BranchManagerController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        try {
            $managers = $this->userService->filterUsers($request, 'branch_manager', PaginationEnum::DefaultCount->value);
            $packages = SubscriptionPackage::all();
            return view('dashboard.branch_managers.index', compact('managers', 'packages'));
        } catch (\Throwable $e) {
            toastr()->error(__('messages.fetch_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        try {
            $user = User::where('role', 'branch_manager')
                ->with(['branchManager.branches.user',  'subscriptions.package'])
                ->withTrashed()
                ->findOrFail($id);
            $packages = SubscriptionPackage::all();

            return view('dashboard.branch_managers.show', compact('user', 'packages'));
        } catch (\Throwable $e) {
            toastr()->error(__('messages.fetch_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }


    public function store(UserRequest $request)
    {
        try {

            $data = $request->validated();
            $data['status'] = 'inactive';
            $user = $this->userService->createUser($data, 'branch_manager');
            $user->branchManager()->create([
                'user_id' => $user->id,
            ]);

            $user->load(['branchManager' => function ($q) {
                $q->withCount('branches');
            }]);
            return response()->json([
                'message' => __('messages.added_successfully'),
                'data' => $user,
                'branches_count' => $user->branchManager?->branches_count ?? 0,
            ], 200);
        } catch (\Throwable $e) {
            toastr()->error(__('messages.add_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::where('role', 'branch_manager')->findOrFail($id);
            $data = $request->validated();

            $this->userService->updateUser($user, $data);

            $user->load(['branchManager' => function ($q) {
                $q->withCount('branches');
            }]);

            return response()->json([
                'message' => __('messages.updated_successfully'),
                'data' => $user,
                'branches_count' => $user->branchManager?->branches_count ?? 0,
            ], 200);
        } catch (\Throwable $e) {
            toastr()->error(__('messages.update_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::where('role', 'branch_manager')->findOrFail($id);
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
            $user = User::where('role', 'branch_manager')->onlyTrashed()->findOrFail($id);
            $this->userService->restoreUser($user);

            toastr()->success(__('messages.restored_successfully'));
            return redirect()->route('dashboard.branch_managers.index');
        } catch (\Throwable $e) {
            toastr()->error(__('messages.restore_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function activate($id)
    {
        try {
            $manager = User::where('role', 'branch_manager')->findOrFail($id);
            $this->userService->changeStatus($manager, 'active');


            $managerBranches = $manager->branchManager?->branches;
            if ($managerBranches) {
                foreach ($managerBranches as $branch) {
                    $this->userService->changeStatus($branch->user, 'active');
                }
            }

            // return response()->json(['status' => true, 'message' => __('messages.user_activated_successfully'), 'data' => $user]);
            return response()->json([
                'status' => true,
                'message' => __('messages.user_activated_successfully'),
                'data' => [
                    'id' => $manager->id,
                    'toggle_url' => route('dashboard.branch_managers.deactivate', $manager->id),
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
            $manager = User::where('role', 'branch_manager')->findOrFail($id);
            $this->userService->changeStatus($manager, 'inactive');

            $managerBranches = $manager->branchManager?->branches;
            if ($managerBranches) {
                foreach ($managerBranches as $branch) {
                    $this->userService->changeStatus($branch->user, 'inactive');
                }
            }

            // return response()->json(['status' => true, 'message' => __('messages.user_deactivated_successfully'), 'data' => $user]);
            return response()->json([
                'status' => true,
                'message' => __('messages.user_deactivated_successfully'),
                'data' => [
                    'id' => $manager->id,
                    'toggle_url' => route('dashboard.branch_managers.activate', $manager->id),
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error("Error deactivating branch manager ID {$id}: " . $e->getMessage(), [
                'exception' => $e
            ]);
            toastr()->error(__('messages.update_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }
}