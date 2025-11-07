<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchManager;
use App\Models\Company;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // public function index(Request $request)
    // {
    //     $user = auth()->user();
    //     $month = $request->month ?? null;
    //     $year  = $request->year ?? null;
    //     $companyId = $request->company_id ?? null;
    //     $branchId = $request->branch_id ?? null;

    //     $companies = [];
    //     $branches = [];
    //     if ($user->role === 'super_admin' || $user->role == 'branch_manager') {
    //         $companies = Company::select('id', 'name_ar')->get();
    //     }
    //     if ($user->role === 'super_admin') {
    //         $branches = Branch::with('user:id,full_name')->select('id', 'user_id')->get();
    //     } elseif ($user->role == 'branch_manager') {
    //         $branches = $user->branchManager->branches()->with('user:id,full_name')->select('id', 'user_id')->get();
    //     } else {
    //         $branches = Branch::where('id', $user->branch->id)
    //             ->withCount('orders')
    //             ->with('user:id,full_name')
    //             ->get();
    //     }

    //     // Super admin dashboard stats
    //     if ($user->role === 'super_admin') {
    //         // ✅ Only orders filtered by company
    //         $totalBranchesCount = Branch::count();
    //         $totalManagersCount = BranchManager::count();
    //         $totalOrdersCount   = Order::when($companyId, fn($q) => $q->where('company_id', $companyId))->count();
    //         $totalOrdersAmount  = Order::when($companyId, fn($q) => $q->where('company_id', $companyId))->sum('total_order');

    //         // Chart data: orders grouped by month
    //         $monthlyOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
    //             ->when($companyId, fn($q) => $q->where('company_id', $companyId))
    //             ->whereYear('created_at', $year ?? now()->year)
    //             ->groupBy('month')
    //             ->orderBy('month')
    //             ->pluck('count', 'month')
    //             ->toArray();

    //         $months = range(1, 12);
    //         $ordersByMonth = [];
    //         foreach ($months as $m) {
    //             $ordersByMonth[] = $monthlyOrders[$m] ?? 0;
    //         }
    //     } elseif ($user->role === 'branch_manager') {
    //         $branchIds = $user->branchManager->branches->pluck('id')->toArray();
    //         $totalBranchesCount = count($branchIds);
    //         $totalManagersCount = 1;
    //         $totalOrdersCount   = Order::whereIn('branch_id', $branchIds)->count();
    //         $totalOrdersAmount  = Order::whereIn('branch_id', $branchIds)->sum('total_order');
    //         $ordersByMonth = [];
    //     } else {
    //         $branchId = $user->branch->id;
    //         $totalBranchesCount = 1;
    //         $totalManagersCount = 1;
    //         $totalOrdersCount   = Order::where('branch_id', $branchId)->count();
    //         $totalOrdersAmount  = Order::where('branch_id', $branchId)->sum('total_order');
    //         $ordersByMonth = [];
    //     }

    //     // ✅ Orders filtered by month/year/company
    //     $ordersQuery = Order::query();

    //     if ($month) $ordersQuery->whereMonth('created_at', $month);
    //     if ($year) $ordersQuery->whereYear('created_at', $year);
    //     if ($companyId) $ordersQuery->where('company_id', $companyId);
    //     if ($branchId) $ordersQuery->where('branch_id', $branchId);

    //     if ($user->role === 'branch_manager') {
    //         $ordersQuery->whereIn('branch_id', $branchIds);
    //     } elseif ($user->role === 'branch') {
    //         $ordersQuery->where('branch_id', $branchId);
    //     }

    //     $ordersCount = $ordersQuery->count();
    //     $ordersTotal = $ordersQuery->sum('total_order');

    //     // Chart (optional by branches)
    //     if ($user->role === 'super_admin') {
    //         $branches = Branch::withCount(['orders' => function ($q) use ($month, $year, $companyId) {
    //             if ($month) $q->whereMonth('created_at', $month);
    //             if ($year) $q->whereYear('created_at', $year);
    //             if ($companyId) $q->where('company_id', $companyId);
    //         }])->get();

    //         $chartLabels = $branches->pluck('user.full_name')->toArray();
    //         $chartData   = $branches->pluck('orders_count')->toArray();
    //     } else {
    //         $chartLabels = [];
    //         $chartData   = [];
    //     }


    //     $chartLabels = $branches->pluck('user.full_name')->toArray();
    //     $chartData = $branches->pluck('orders_count')->toArray();

    //     $totalByBranch = Branch::with(['orders' => function ($q) use ($month, $year, $companyId) {
    //         if ($month) $q->whereMonth('created_at', $month);
    //         if ($year) $q->whereYear('created_at', $year);
    //         if ($companyId) $q->where('company_id', $companyId);
    //     }])
    //         ->get()
    //         ->map(function ($branch) {
    //             return [
    //                 'branch_name' => $branch->user?->full_name ?? '---',
    //                 'total_order' => $branch->orders->sum('total_order'),
    //             ];
    //         });

    //     $totalBranchLabels = $totalByBranch->pluck('branch_name')->toArray();
    //     $totalBranchData = $totalByBranch->pluck('total_order')->toArray();

    //     // إجمالي المبيعات وعدد الطلبات لكل شركة
    //     // إجمالي المبيعات وعدد الطلبات لكل شركة (دائمًا للسنة الحالية)
    //     $currentYear = now()->year;

    //     $companyStats = Order::selectRaw('company_id, COUNT(*) as total_orders, SUM(total_order) as total_sales')
    //         ->whereYear('created_at', $currentYear)
    //         ->groupBy('company_id')
    //         ->with('company:id,name_ar')
    //         ->get();

    //     $companyNames  = $companyStats->pluck('company.name_ar')->toArray();
    //     $companySales  = $companyStats->pluck('total_sales')->toArray();   // For Donut
    //     $companyOrders = $companyStats->pluck('total_orders')->toArray();  // For Bar Chart

    //     $revenueByCompany = \App\Models\Order::selectRaw('company_id, SUM(total_order) as total_revenue')
    //         ->with('company:id,name_ar')
    //         ->groupBy('company_id')
    //         ->get();

    //     $revenueLabels = $revenueByCompany->pluck('company.name_ar')->toArray();
    //     $revenueData = $revenueByCompany->pluck('total_revenue')->toArray();


    //     return view('dashboard.home.index', compact(
    //         'totalBranchesCount',
    //         'totalManagersCount',
    //         'totalOrdersCount',
    //         'totalOrdersAmount',
    //         'ordersCount',
    //         'ordersTotal',
    //         'month',
    //         'year',
    //         'companyId',
    //         'companies',
    //         'chartLabels',
    //         'chartData',
    //         'ordersByMonth',
    //         'branchId',
    //         'branches',
    //         'totalBranchLabels',
    //         'totalBranchData',

    //         'companyNames',
    //         'companySales',
    //         'companyOrders',
    //         'revenueLabels',
    //         'revenueData'
    //     ));
    // }


    public function index(Request $request)
    {
        $user = auth()->user();
        $month = $request->month;
        $year = $request->year ?? now()->year;
        $companyId = $request->company_id;
        $branchId = $request->branch_id;

        // Companies for filter
        $companies = in_array($user->role, ['super_admin', 'branch_manager'])
            ? Company::select('id', 'name_ar')->get()
            : collect();

        // Branches for filter
        $branches = match ($user->role) {
            'super_admin' => Branch::with('user:id,full_name')->get(),
            'branch_manager' => $user->branchManager->branches()->with('user:id,full_name')->get(),
            default => Branch::where('id', $user->branch->id)->with('user:id,full_name')->get(),
        };

        // Base Orders Query
        $ordersQuery = Order::query();
        if ($month) $ordersQuery->whereMonth('created_at', $month);
        if ($year) $ordersQuery->whereYear('created_at', $year);
        if ($companyId) $ordersQuery->where('company_id', $companyId);
        if ($branchId) $ordersQuery->where('branch_id', $branchId);

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
            'orders' => function ($q) use ($month, $year, $companyId) {
                if ($month) $q->whereMonth('created_at', $month);
                if ($year) $q->whereYear('created_at', $year);
                if ($companyId) $q->where('company_id', $companyId);
            }
        ])->loadCount([
            'orders as orders_count' => function ($q) use ($month, $year, $companyId) {
                if ($month) $q->whereMonth('created_at', $month);
                if ($year) $q->whereYear('created_at', $year);
                if ($companyId) $q->where('company_id', $companyId);
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
        if (auth()->user()->role === 'branch_manager') {
            // Get IDs of branches managed by this branch manager
            $branchIds = auth()->user()->branchManager->branches->pluck('id')->toArray();
            $companyStatsQuery->whereIn('branch_id', $branchIds);
        } elseif (auth()->user()->role === 'branch') {
            // Only the branch's own orders
            $companyStatsQuery->where('branch_id', auth()->user()->branch->id);
        }

        $companyStats = $companyStatsQuery->groupBy('company_id')
            ->with('company:id,name_ar')
            ->get();

        $companyNames = $companyStats->pluck('company.name_ar')->toArray();
        $companySales = $companyStats->pluck('total_sales')->toArray();
        $companyOrders = $companyStats->pluck('total_orders')->toArray();


        // Dashboard stats
        $totalBranchesCount = $branches->count();
        $totalManagersCount = ($user->role === 'super_admin') ? BranchManager::count() : 1;

        // عدد الطلبات وإجمالي الطلبات بعد تطبيق الفلاتر
        $ordersCount = $ordersQuery->count();
        $ordersTotal = $ordersQuery->sum('total_order');

        $totalOrdersCount = $ordersCount;
        $totalOrdersAmount = $ordersTotal;


        $monthlyOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count, SUM(total_order) as total')
            ->when($companyId, fn($q) => $q->where('company_id', $companyId))
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
        ));
    }
}
