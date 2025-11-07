@extends('dashboard.layouts.app')

@section('content')
    <div class="card mb-4">
        <div class="card-header bg-main ">
            <h5 class="text-light">تفاصيل الفرع</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">

                <div class="col-md-6">
                    <strong>اسم الفرع:</strong> {{ $branch->full_name }}
                </div>

                <div class="col-md-6">
                    <strong>رقم الفرع:</strong> {{ $branch->branch->branch_number }}
                </div>
                <div class="col-md-6">
                    <strong>الهاتف:</strong> {{ $branch->phone }}
                </div>

                <div class="col-md-6">
                    <strong>الحالة:</strong>
                    <span class="badge bg-{{ $branch->status === 'active' ? 'success' : 'danger' }}">
                        {!! accountStatusBadge($branch->status) !!}
                    </span>
                </div>
                <div class="col-md-6">
                    <strong>مدير الفرع:</strong> {{ $branch->branch->manager->user->full_name ?? '-' }}
                </div>

                {{-- الطلبات المرتبطة --}}
                <div class="col-12 mt-3">
                    <h6>الطلبات المرتبطة:</h6>
                    <p>
                        <strong>عدد الطلبات:</strong> {{ $ordersCount }} |
                        <strong>إجمالي الطلبات:</strong> {{ number_format($ordersTotal, 2) }} ر.س
                    </p>

                    @if ($branch->branch && $branch->branch->orders->count())
                        <div style="max-height: 300px; overflow-y: auto;">
                            <table class="table table-striped table-hover mb-0">
                                <thead class="bg-secondary text-light">
                                    <tr>
                                        <th>رقم الطلب</th>
                                        <th>الشركة</th>
                                        <th>المبلغ</th>
                                        <th>التاريخ</th>
                                        <th>الوقت</th>
                                        <th>الحالة</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($branch->branch->orders as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->company->name_ar ?? '-' }}</td>
                                            <td>{{ number_format($order->total_order, 2) }} ر.س</td>
                                            <td>{{ $order->date }}</td>
                                            <td>{{ $order->time }}</td>
                                            <td>
                                                <span
                                                    class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'pending' ? 'secondary' : 'danger') }}">
                                                    {{ __('dashboard.' . $order->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p>لا توجد طلبات مرتبطة.</p>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection
