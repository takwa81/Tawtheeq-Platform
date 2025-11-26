<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchManager;
use App\Models\Company;
use App\Models\Order;
use App\Models\SubscriptionPackage;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{


    public function index(Request $request)
    {
        $user = auth()->user();
        $month = $request->month;
        $year = $request->year ?? now()->year;
        $companyId = $request->company_id;
        $branchId = $request->branch_id;
        $branchManagerId = $request->branch_manager_id;

        // Companies for filter
        $companies = in_array($user->role, ['super_admin', 'branch_manager'])
            ? Company::all()
            : collect();

        // Branches for filter
        $branches = match ($user->role) {
            'super_admin' => Branch::with('user:id,full_name')->get(),
            'branch_manager' => $user->branchManager->branches()->with('user:id,full_name')->get(),
            default => Branch::where('id', $user->branch->id)->with('user:id,full_name')->get(),
        };

        $branchIdsForManager = null;
        if ($branchManagerId) {
            $manager = BranchManager::where('user_id', $branchManagerId)->first();
            if ($manager) {
                $branchIdsForManager = $manager->branches->pluck('id')->toArray();
            }
        }

        // Base Orders Query
        $ordersQuery = Order::query();
        if ($month) $ordersQuery->whereMonth('created_at', $month);
        if ($year) $ordersQuery->whereYear('created_at', $year);
        if ($companyId) $ordersQuery->where('company_id', $companyId);
        if ($branchId) $ordersQuery->where('branch_id', $branchId);
        if ($branchIdsForManager) $ordersQuery->whereIn('branch_id', $branchIdsForManager);



        if ($user->role === 'branch_manager') {
            $branchIds = $user->branchManager->branches->pluck('id')->toArray();
            $ordersQuery->whereIn('branch_id', $branchIds);
        } elseif ($user->role === 'branch') {
            $ordersQuery->where('branch_id', $user->branch->id);
        }

        // Dashboard stats
        $totalBranchesCount = $branches->count();
        $totalManagersCount = ($user->role === 'super_admin') ? BranchManager::count() : 1;
        $totalOrdersCount = $ordersQuery->count();
        $totalOrdersAmount = $ordersQuery->sum('total_order');

        // Orders per branch
        $branchesWithOrders = $branches->load([
            'orders' => function ($q) use ($month, $year, $companyId, $branchIdsForManager) {
                if ($month) $q->whereMonth('created_at', $month);
                if ($year) $q->whereYear('created_at', $year);
                if ($companyId) $q->where('company_id', $companyId);
                if ($branchIdsForManager) $q->whereIn('branch_id', $branchIdsForManager);
            }
        ])->loadCount([
            'orders as orders_count' => function ($q) use ($month, $year, $companyId, $branchIdsForManager) {
                if ($month) $q->whereMonth('created_at', $month);
                if ($year) $q->whereYear('created_at', $year);
                if ($companyId) $q->where('company_id', $companyId);
                if ($branchIdsForManager) $q->whereIn('branch_id', $branchIdsForManager);
            }
        ]);

        $branchLabels = $branchesWithOrders->pluck('user.full_name')->toArray();
        $branchData = $branchesWithOrders->pluck('orders_count')->toArray();

        // Total sales per branch
        $totalByBranch = $branchesWithOrders->map(fn($b) => [
            'branch_name' => $b->user?->full_name ?? '---',
            'total_order' => $b->orders->sum('total_order'),
        ]);

        $totalBranchLabels = $totalByBranch->pluck('branch_name')->toArray();
        $totalBranchData = $totalByBranch->pluck('total_order')->toArray();


        $companyStatsQuery = Order::selectRaw('company_id, COUNT(*) as total_orders, SUM(total_order) as total_sales')
            ->whereYear('created_at', $year);

        // Apply role-based filtering
        if ($branchIdsForManager) {
            $companyStatsQuery->whereIn('branch_id', $branchIdsForManager);
        } elseif (auth()->user()->role === 'branch_manager') {
            // Get IDs of branches managed by this branch manager
            $branchIds = auth()->user()->branchManager->branches->pluck('id')->toArray();
            $companyStatsQuery->whereIn('branch_id', $branchIds);
        } elseif (auth()->user()->role === 'branch') {
            // Only the branch's own orders
            $companyStatsQuery->where('branch_id', auth()->user()->branch->id);
        }

        $companyStats = $companyStatsQuery->groupBy('company_id')
            ->with('company')->get();

        $companyNames = $companyStats->pluck('company.name')->toArray();
        $companySales = $companyStats->pluck('total_sales')->toArray();
        $companyOrders = $companyStats->pluck('total_orders')->toArray();


        // Dashboard stats
        $totalBranchesCount = $branches->count();
        $totalManagersCount = ($user->role === 'super_admin') ? BranchManager::count() : 1;

        $ordersCount = $ordersQuery->count();
        $ordersTotal = $ordersQuery->sum('total_order');

        $totalOrdersCount = $ordersCount;
        $totalOrdersAmount = $ordersTotal;


        $monthlyOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count, SUM(total_order) as total')
            ->when($companyId, fn($q) => $q->where('company_id', $companyId))
            ->when(isset($branchIdsForManager), fn($q) => $q->whereIn('branch_id', $branchIdsForManager))
            ->when(isset($branchIds), fn($q) => $q->whereIn('branch_id', $branchIds))
            ->when($branchId, fn($q) => $q->where('branch_id', $branchId))
            ->when(auth()->user()->role === 'branch', function ($q) {
                // Limit to the authenticated branch user's branch
                $q->where('branch_id', auth()->user()->branch->id);
            })
            ->whereYear('created_at', $year)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->keyBy('month');

        $ordersByMonthCount = [];
        $ordersByMonthTotal = [];
        for ($m = 1; $m <= 12; $m++) {
            $ordersByMonthCount[] = $monthlyOrders[$m]->count ?? 0;
            $ordersByMonthTotal[] = $monthlyOrders[$m]->total ?? 0;
        }





        $chartData = SubscriptionPackage::withCount('subscriptions')
            ->get(['id', 'name_en', 'name_ar']);

        $totalSubscriptions = $chartData->sum('subscriptions_count');


        $branchManagers = User::where('role', 'branch_manager')->get();

        return view('dashboard.home.index', compact(
            'totalBranchesCount',
            'totalManagersCount',
            'totalOrdersCount',
            'totalOrdersAmount',
            'month',
            'year',
            'companyId',
            'branchId',
            'companies',
            'branches',
            'branchLabels',
            'branchData',
            'totalBranchLabels',
            'totalBranchData',
            'companyNames',
            'companySales',
            'companyOrders',
            'ordersCount',
            'ordersTotal',
            'ordersByMonthCount',
            'ordersByMonthTotal',
            'chartData',
            'totalSubscriptions',
            'branchManagers'
        ));
    }
}
