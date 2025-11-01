<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchManager;
use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $month = $request->month ?? null;
        $year  = $request->year ?? null;

        if ($user->role === 'super_admin') {
            $totalBranchesCount = Branch::count();
            $totalManagersCount = BranchManager::count();
            $totalOrdersCount   = Order::count();
            $totalOrdersAmount  = Order::sum('total_order');

            // Chart: Orders count by month
            $monthlyOrders = Order::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
                ->whereYear('created_at', $year ?? Carbon::now()->year)
                ->groupBy('month')
                ->orderBy('month')
                ->pluck('count', 'month')
                ->toArray();

            $months = range(1, 12);
            $ordersByMonth = [];
            foreach ($months as $m) {
                $ordersByMonth[] = $monthlyOrders[$m] ?? 0;
            }
        } elseif ($user->role === 'branch_manager') {
            $branchIds = $user->branchManager->branches->pluck('id')->toArray();
            $totalBranchesCount = count($branchIds);
            $totalManagersCount = 1;
            $totalOrdersCount   = Order::whereIn('branch_id', $branchIds)->count();
            $totalOrdersAmount  = Order::whereIn('branch_id', $branchIds)->sum('total_order');
            $ordersByMonth = [];
        } else {
            $branchId = $user->branch->id;
            $totalBranchesCount = 1;
            $totalManagersCount = 1;
            $totalOrdersCount   = Order::where('branch_id', $branchId)->count();
            $totalOrdersAmount  = Order::where('branch_id', $branchId)->sum('total_order');
            $ordersByMonth = [];
        }


        $ordersQuery = Order::query();

        if ($month) $ordersQuery->whereMonth('created_at', $month);
        if ($year) $ordersQuery->whereYear('created_at', $year);

        if ($user->role === 'branch_manager') {
            $ordersQuery->whereIn('branch_id', $branchIds);
        } elseif ($user->role === 'branch') {
            $ordersQuery->where('branch_id', $branchId);
        }

        $ordersCount = $ordersQuery->count();
        $ordersTotal = $ordersQuery->sum('total_order');

        if ($user->role === 'super_admin') {
            $branches = Branch::withCount(['orders' => function ($q) use ($month, $year) {
                if ($month) $q->whereMonth('created_at', $month);
                if ($year) $q->whereYear('created_at', $year);
            }])->get();

            $chartLabels = $branches->pluck('user.full_name')->toArray();
            $chartData   = $branches->pluck('orders_count')->toArray();
        } else {
            $chartLabels = [];
            $chartData   = [];
        }

        return view('dashboard.home.index', compact(
            'totalBranchesCount',
            'totalManagersCount',
            'totalOrdersCount',
            'totalOrdersAmount',
            'ordersCount',
            'ordersTotal',
            'month',
            'year',
            'chartLabels',
            'chartData',
            'ordersByMonth'
        ));
    }
}
