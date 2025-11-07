<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\PaginationEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\OrderRequest;
use App\Models\Branch;
use App\Models\Company;
use App\Models\Order;
use App\Traits\ImageHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    use ImageHandler;

    public function index(Request $request)
    {
        try {
            $user = auth()->user();

            $orders = Order::with(['branch', 'company', 'creator'])
                ->when($user->role === 'branch' && $user->branch, function ($query) use ($user) {
                    $query->where('created_by', $user->id)
                        ->where('branch_id', $user->branch->id);
                })
                ->when($user->role === 'branch_manager', function ($query) use ($user) {
                    $branchIds = $user->branchManager?->branches()->pluck('id')->toArray() ?? [];
                    $query->whereIn('branch_id', $branchIds);
                })
                ->filter($request->only(['order_number', 'customer_name', 'date', 'branch_id', 'customer_phone', 'company_id', 'sort']))
                ->paginate(PaginationEnum::DefaultCount->value)
                ->appends($request->all());

            $companies = Company::all();
            if ($user->role === 'super_admin') {
                $branches = Branch::with('user')->get();
            } elseif ($user->role === 'branch_manager') {
                $branches = Branch::with('user')
                    ->whereHas('manager', function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                    })
                    ->get();
            } else {
                $branches = collect();
            }
            return view('dashboard.orders.index', compact('orders', 'companies', 'branches'));
        } catch (\Throwable $e) {
            Log::error('Error fetching orders: ' . $e->getMessage(), [
                'exception' => $e,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            toastr()->error(__('messages.fetch_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }


    public function create()
    {

        try {
            $branches = Branch::all();
            $companies = Company::all();
            return view('dashboard.orders.create', compact('branches', 'companies'));
        } catch (\Throwable $e) {
            Log::error('Error fetching orders: ' . $e->getMessage(), [
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
            $order = Order::find($id);
            return view('dashboard.orders.show', compact('order'));
        } catch (\Throwable $e) {
            Log::error('Error fetching orders: ' . $e->getMessage(), [
                'exception' => $e,
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
            toastr()->error(__('messages.fetch_failed') . ': ' . $e->getMessage());
            return redirect()->back();
        }
    }

    public function store(OrderRequest $request)
    {
        try {

            $data = $request->validated();
            $user = auth()->user();
            if ($user->role == 'branch' && $user->branch) {
                $data['branch_id'] = $user->branch->id;
            }
            $data['created_by'] = $user->id;
            $imagePath = null;
            if ($request->hasFile('order_image')) {
                $imagePath = $this->storeImage($request->file('order_image'), 'orders');
            }
            $data['order_image'] = $imagePath;
            $data['status'] = "completed";


            Order::create($data);

            toastr()->success(__('messages.added_successfully'));
            return redirect()->route('dashboard.orders.index');
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => false,
                'message' => __('messages.add_failed') . ': ' . $e->getMessage(),
            ], 500);
        }
    }
}