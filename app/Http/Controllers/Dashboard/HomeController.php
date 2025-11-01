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
        $month = $request->month ?? Carbon::now()->month;
        $year  = $request->year ?? Carbon::now()->year;

        if ($user->role === 'super_admin') {
            $branchesCount = Branch::count();
            $managersCount = BranchManager::count();

            // Chart data for orders per branch
            $branches = Branch::withCount(['orders' => function($q) use($month, $year) {
                $q->whereMonth('created_at', $month)
                  ->whereYear('created_at', $year);
            }])->get();

            $ordersCount = $branches->sum('orders_count');
            $ordersTotal = Order::whereMonth('created_at', $month)
                                ->whereYear('created_at', $year)
                                ->sum('total_order');

            $chartLabels = $branches->pluck('user.full_name')->toArray();
            $chartData   = $branches->pluck('orders_count')->toArray();

        } elseif ($user->role === 'branch_manager') {
            $branchIds = $user->branchManager->branches->pluck('id')->toArray();
            $branchesCount = count($branchIds);
            $managersCount = 1;
            $ordersQuery = Order::whereIn('branch_id', $branchIds)
                                ->whereMonth('created_at', $month)
                                ->whereYear('created_at', $year);

            $ordersCount = $ordersQuery->count();
            $ordersTotal = $ordersQuery->sum('total_order');

            $chartLabels = $user->branchManager->branches->pluck('user.full_name')->toArray();
            $chartData   = $ordersQuery->groupBy('branch_id')
                                ->selectRaw('branch_id, count(*) as total')
                                ->pluck('total', 'branch_id')->values()->toArray();
        } else { // branch
            $branchesCount = 1;
            $managersCount = 1;
            $ordersQuery = Order::where('branch_id', $user->branch->id)
                                ->whereMonth('created_at', $month)
                                ->whereYear('created_at', $year);

            $ordersCount = $ordersQuery->count();
            $ordersTotal = $ordersQuery->sum('total_order');

            $chartLabels = [$user->branch->user->full_name];
            $chartData   = [$ordersCount];
        }

        return view('dashboard.home.index', compact(
            'branchesCount', 'managersCount', 'ordersCount', 'ordersTotal',
            'month', 'year', 'chartLabels', 'chartData'
        ));
    }
}
