@extends('dashboard.layouts.app')

@section('content')
    <x-dashboard.page-header :title="__('dashboard.orders')" addRoute="{{ route('dashboard.orders.create') }}" />

    {{-- <div class="row g-3">
        @forelse ($orders as $order)
            <div class="col-lg-4 col-md-6 col-sm-12">
                <div class="card border-0 shadow-sm rounded-3 h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h6 class="fw-bold text-primary mb-2">
                                رقم الطلب: {{ $order->order_number }}
                            </h6>
                            <p class="text-muted small mb-1">
                                <strong>الفرع:</strong> {{ $order->branch->user->full_name ?? '-' }}
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>الشركة:</strong> {{ $order->company->name_ar ?? '-' }}
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>المبلغ:</strong> {{ number_format($order->total_order, 2) }} ر.س
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>التاريخ:</strong> {{ $order->date }}
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>الوقت:</strong> {{ $order->time }}
                            </p>
                            <p class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'secondary') }}">
                                {{ __($order->status) }}
                            </p>
                        </div>

                        <div class="mt-3 d-flex justify-content-between align-items-center">
                            <a href="{{ route('dashboard.orders.edit', $order) }}" class="btn btn-md rounded font-sm edit-data">
                                <i class="material-icons md-edit"></i>
                            </a>
                            <form action="{{ route('dashboard.orders.destroy', $order) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-md btn-danger rounded font-sm  delete-button">
                                    <i class="material-icons md-delete"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <x-no-data-found />
            </div>
        @endforelse
    </div> --}}
    <div class="my-3">
        <form method="GET" action="{{ route('dashboard.orders.index') }}" class="row g-2 mb-3">
            <div class="col-md-3">
                <input type="text" name="order_number" class="form-control bg-white" placeholder="رقم الطلب"
                    value="{{ request('order_number') }}">
            </div>

            <div class="col-md-3">
                <input type="text" name="customer_name" class="form-control bg-white" placeholder="اسم العميل"
                    value="{{ request('customer_name') }}">
            </div>

            <div class="col-md-3">
                <input type="text" name="customer_phone" class="form-control bg-white" placeholder="هاتف العميل"
                    value="{{ request('customer_phone') }}">
            </div>

            <div class="col-md-3">
                <select name="company_id" class="form-select  bg-white">
                    <option value="">كل الشركات</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->name_ar }}
                        </option>
                    @endforeach
                </select>
            </div>

            @if (auth()->user()->role === 'super_admin' || auth()->user()->role === 'branch_manager' )
                <div class="col-md-3">
                    <select name="branch_id" class="form-select bg-white">
                        <option value="">كل الفروع</option>
                        @foreach ($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->user->full_name ?? 'فرع #' . $branch->id }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <div class="col-md-3">
                <input type="date" name="date" class="form-control bg-white" value="{{ request('date') }}"
                    placeholder="تاريخ الطلب">
            </div>

            <div class="col-md-3">
                <select name="sort" class="form-select bg-white">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>الأحدث أولاً</option>
                    <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>الأقدم أولاً</option>
                </select>
            </div>

            <div class="col-md-1 mt-2">
                <button type="submit" class="btn w-100 btn-md bg-main">
                    <i class="material-icons md-search"></i>
                </button>
            </div>
            <div class="col-md-1 mt-2">
                <a href="{{ route('dashboard.orders.index') }}" class="btn w-100 btn-md bg-secondary">
                    <i class="material-icons md-refresh"></i>
                </a>
            </div>
        </form>

    </div>
    <div class="card mb-4">
        <div class="card-body p-0">
            <div class="" style="max-height: 400px; overflow-y: auto;">
                <table class="table table-striped table-hover mb-0">
                    <thead class="bg-main text-light">
                        <tr>
                            <th>رقم الطلب</th>
                            <th>الفرع</th>
                            <th>الشركة</th>
                            <th>المبلغ</th>
                            <th>التاريخ</th>
                            <th>الوقت</th>
                            <th>الحالة</th>
                            <th>تاريخ الإنشاء</th>
                            <th>إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>{{ $order->order_number ?? '_' }}</td>
                                <td>{{ $order->branch->user->full_name ?? '-' }}</td>
                                <td>{{ $order->company->name_ar ?? '-' }}</td>
                                <td>{{ number_format($order->total_order, 2) }} ر.س</td>
                                <td>{{ $order->date }}</td>
                                <td>{{ $order->time }}</td>

                                <td>
                                    <span
                                        class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'cancelled' ? 'danger' : 'secondary') }}">
                                        {{ __('dashboard.' . $order->status) }}

                                    </span>
                                </td>
                                <td>
                                    {{ $order->created_at->format('d-m-Y') }} ({{ $order->created_at->diffForHumans() }})
                                </td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('dashboard.orders.show', $order) }}"
                                        class="btn btn-md rounded font-sm bg-info">
                                        <i class="material-icons md-remove_red_eye"></i>
                                    </a>

                                    <form action="{{ route('dashboard.orders.destroy', $order) }}" method="POST"
                                        class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-md bg-danger rounded font-sm  delete-button">
                                            <i class="material-icons md-delete"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-3"><x-no-data-found /></td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="mt-4">
        <x-dashboard.pagination :paginator="$orders" />
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('admin/dashboard/pages/delete.js') }}"></script>
@endsection
