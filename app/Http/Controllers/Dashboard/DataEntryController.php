<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\UserRequest;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;

class DataEntryController extends Controller
{
    protected $userService;
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index(Request $request)
    {
        try {
            $dataEntries = $this->userService->filterUsers($request, 'dataEntry', PaginationEnum::DefaultCount->value);
            return view('dashboard.users.dataEntries.index', compact('dataEntries'));
        } catch (\Throwable $e) {
            toastr()->error(__('messages.fetch_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        try {
            $user = User::where('user_type', 'dataEntry')->with('dataEntry')->withTrashed()->findOrFail($id);
            return view('dashboard.users.dataEntries.show', compact('user'));
        } catch (\Throwable $e) {
            toastr()->error(__('messages.fetch_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function store(UserRequest $request)
    {
        try {

            $data = $request->validated();
            $user = $this->userService->createUser($data, 'dataEntry');
            $user->dataEntry()->create([
                'user_id' => $user->id,
            ]);
            return response()->json(['message' => __('messages.added_successfully'), 'data' => $user], 200);
        } catch (\Throwable $e) {
            toastr()->error(__('messages.add_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function update(UserRequest $request, $id)
    {
        try {
            $user = User::where('user_type', 'dataEntry')->findOrFail($id);
            $data = $request->validated();

            $this->userService->updateUser($user, $data);

            return response()->json(['message' => __('messages.updated_successfully'), 'data' => $user], 200);
        } catch (\Throwable $e) {
            toastr()->error(__('messages.update_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::where('user_type', 'dataEntry')->findOrFail($id);
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
            $user = User::where('user_type', 'dataEntry')->onlyTrashed()->findOrFail($id);
            $this->userService->restoreUser($user);

            toastr()->success(__('messages.restored_successfully'));
            return redirect()->route('dashboard.data_entries.index');
        } catch (\Throwable $e) {
            toastr()->error(__('messages.restore_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function activate($id)
    {
        try {
            $user = User::where('user_type', 'dataEntry')->findOrFail($id);
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
            $user = User::where('user_type', 'dataEntry')->findOrFail($id);
            $this->userService->changeStatus($user, 'inactive');

            return response()->json(['status' => true, 'message' => __('messages.user_deactivated_successfully'), 'data' => $user]);
        } catch (\Throwable $e) {
            toastr()->error(__('messages.update_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }
}
