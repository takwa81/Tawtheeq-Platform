<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SubscriptionPackageRequest;
use App\Models\SubscriptionPackage;
use App\Traits\FiltersListTrait;
use Illuminate\Http\Request;

class SubscriptionPackageController extends Controller
{
    use FiltersListTrait;

    public function index(Request $request)
    {
        try {
            $query = SubscriptionPackage::withCount('subscriptions');

            $query = $this->applyNameFilterAndSorting($request, $query);

            $packages  = $query->paginate(PaginationEnum::DefaultCount->value)->appends($request->all());
            $stats = [
                'total_subscriptions' => SubscriptionPackage::withCount('subscriptions')->get()->sum('subscriptions_count'),
                'top_package' => SubscriptionPackage::withCount('subscriptions')->orderBy('subscriptions_count', 'desc')->first(),
                'low_package' => SubscriptionPackage::withCount('subscriptions')->orderBy('subscriptions_count', 'asc')->first(),
            ];

            $chartData = SubscriptionPackage::withCount('subscriptions')
                ->get(['id', 'name_en', 'name_ar']); 


            $totalSubscriptions = $chartData->sum('subscriptions_count');
            return view('dashboard.subscription_packages.index', compact('packages', 'stats', 'chartData', 'totalSubscriptions'));
        } catch (\Throwable $e) {

            toastr()->error(__('messages.fetch_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function show($id)
    {
        try {
            $package = SubscriptionPackage::withCount('subscriptions')->findOrFail($id);

            return view('dashboard.subscription_packages.show', compact('package'));
        } catch (\Throwable $e) {
            toastr()->error(__('messages.fetch_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }



    public function store(SubscriptionPackageRequest $request)
    {
        try {
            $package = SubscriptionPackage::create($request->validated());
            return response()->json([
                'status' => true,
                'message' => __('messages.added_successfully'),
                'data' => $package
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => __('messages.add_failed') . ': ' . $e->getMessage(),
            ], 500);
        }
    }

    public function update(SubscriptionPackageRequest $request, $id)
    {
        try {
            $package = SubscriptionPackage::findOrFail($id);
            $package->update($request->validated());

            return response()->json([
                'status' => true,
                'message' => __('messages.updated_successfully'),
                'data' => $package
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => false,
                'message' => __('messages.update_failed') . ': ' . $e->getMessage(),
            ], 500);
        }
    }
}
