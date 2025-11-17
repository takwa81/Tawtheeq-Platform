<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SubscriptionRequest;
use App\Models\Subscription;
use App\Models\SubscriptionPackage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SubscriptionController extends Controller
{

    public function index(Request $request)
    {
        try {
            $user = auth()->user();

            $subscriptions = Subscription::with(['user', 'package'])
                ->filter($request->only(['user_id', 'status', 'package_id', 'sort']))
                ->paginate(PaginationEnum::DefaultCount->value)
                ->appends($request->all());
            $packages = SubscriptionPackage::all();
            $users = User::where('role', 'branch_manager')->get();

            return view('dashboard.subscriptions.index', compact('subscriptions', 'packages', 'users'));
        } catch (\Throwable $e) {
            Log::error('Error fetching subscriptions: ' . $e->getMessage(), [
                'exception' => $e,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            toastr()->error(__('messages.fetch_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        try {
            $subscription = Subscription::with(['user.branchManager', 'package'])->findOrFail($id);

          
            return view('dashboard.subscriptions.show', compact('subscription'));
        } catch (\Throwable $e) {
            Log::error('Error fetching subscriptions: ' . $e->getMessage(), [
                'exception' => $e,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            toastr()->error(__('messages.fetch_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function store(SubscriptionRequest $request)
    {
        DB::beginTransaction();

        try {
            $manager = User::findOrFail($request->manager_id);
            $package = SubscriptionPackage::findOrFail($request->package_id);

            $hasActive = Subscription::where('user_id', $manager->id)
                ->where('end_date', '>=', now())
                ->exists();

            if ($hasActive) {
                return back()->with('error', __('messages.manager_has_active_subscription'));
            }

            $subscription = Subscription::create([
                'user_id'   => $manager->id,
                'package_id'   => $package->id,
                'start_date'   => $request->start_date,
                'end_date'     => $request->end_date,
                'status' => 'active'
            ]);

            DB::commit();

            return response()->json([
                'message' => __('messages.subscription_created_successfully'),
                'data' => $subscription,
            ], 200);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'status'  => false,
                'message' => __('messages.add_failed') . ': ' . $e->getMessage(),
            ], 500);
        }
    }
}