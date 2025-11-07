@extends('dashboard.layouts.app')
@section('styles')
    <style>
        strong {
            font-weight: bolder;
        }

        .nav-tabs {
            border-bottom: none !important;
        }

        .nav-tabs .nav-link.active,
        .nav-tabs .nav-item.show .nav-link {
            color: #ffffff;
            background-color: #00c1ca;
        }
    </style>
@endsection
@section('content')
    @php
        $arabicMonths = [
            1 => 'يناير',
            2 => 'فبراير',
            3 => 'مارس',
            4 => 'أبريل',
            5 => 'مايو',
            6 => 'يونيو',
            7 => 'يوليو',
            8 => 'أغسطس',
            9 => 'سبتمبر',
            10 => 'أكتوبر',
            11 => 'نوفمبر',
            12 => 'ديسمبر',
        ];
    @endphp
    <div class="content-header d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="content-title card-title">تفاصيل الفرع ({{ $branch->full_name }})</h2>
        </div>
        <div>
            <a href="javascript:void(0)" onclick="history.back()" class="btn btn-md rounded font-sm">
                <i class="material-icons md-arrow_back"></i>
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-main">
            <h5 class="text-light">تفاصيل الفرع</h5>
        </div>
        <div class="card-body">

            {{-- Tabs --}}
            <ul class="nav nav-tabs" id="branchTab" role="tablist">
                <li class="nav-item mx-1.5 p-1" role="presentation">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info"
                        type="button" role="tab"> <i class="material-icons md-18 me-1 md-info"></i> معلومات الفرع
                    </button>
                </li>
                <li class="nav-item mx-1.5 p-1" role="presentation">
                    <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button"
                        role="tab"> <i class="material-icons md-18 me-1 md-shopping_cart"></i> الطلبات</button>
                </li>
                <li class="nav-item mx-1.5 p-1" role="presentation">
                    <button class="nav-link" id="stats-tab" data-bs-toggle="tab" data-bs-target="#stats" type="button"
                        role="tab"> <i class="material-icons md-18 me-1 md-bar_chart"></i> احصائيات</button>
                </li>
            </ul>

            <div class="tab-content mt-3" id="branchTabContent">

                {{-- معلومات الفرع --}}
                <div class="tab-pane fade show active" id="info" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6"><strong>اسم الفرع:</strong> {{ $branch->full_name }}</div>
                        <div class="col-md-6"><strong>رقم الفرع:</strong> {{ $branch->branch->branch_number }}</div>
                        <div class="col-md-6"><strong>الهاتف:</strong> {{ $branch->phone }}</div>
                        <div class="col-md-6">
                            <strong>الحالة:</strong>
                            <span class="badge bg-{{ $branch->status === 'active' ? 'success' : 'danger' }}">
                                {!! accountStatusBadge($branch->status) !!}
                            </span>
                        </div>
                        <div class="col-md-6"><strong>مدير الفرع:</strong>
                            {{ $branch->branch->manager->user->full_name ?? '-' }}</div>
                        <div class="col-md-6">
                            <strong>عدد الطلبات:</strong> {{ $ordersCount }} |
                            <strong>إجمالي الطلبات:</strong> {{ number_format($ordersTotal, 2) }} ر.س
                        </div>
                    </div>
                </div>

                {{-- الطلبات --}}
                <div class="tab-pane fade" id="orders" role="tabpanel">
                    @if ($orders->count())
                        <div style="max-height: 400px; overflow-y: auto;">
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
                                    @foreach ($orders as $order)
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
                        <div class="mt-3">
                            <div class="pagination-area mt-15 mb-50 d-flex justify-content-center">
                                <b class="my-2 mx-3">{{ __('dashboard.total_count') }} : {{ $orders->total() }} </b>

                                <nav aria-label="Page navigation example">
                                    {{ $orders->appends(['tab' => 'orders'])->links() }} </nav>
                            </div>

                        </div>
                    @else
                        <p>لا توجد طلبات مرتبطة.</p>
                    @endif
                </div>

                {{-- احصائيات --}}
                <div class="tab-pane fade" id="stats" role="tabpanel">
                    <form method="GET" class="row g-2 mb-3">
                        <input type="hidden" name="tab" value="stats">
                        <div class="col-md-3">
                            <select name="year" class="form-select bg-white" onchange="this.form.submit()">
                                @foreach (range(now()->year, now()->year - 5) as $y)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                        {{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                    </form>


                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card card-body">
                                <h5>عدد الطلبات لكل شهر ({{ $year }})</h5>
                                <div id="monthlyOrdersCountChart" style="height: 400px;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-body">
                                <h5>إجمالي الطلبات لكل شهر (ر.س) ({{ $year }})</h5>
                                <div id="monthlyOrdersTotalChart" style="height: 400px;"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const activeTab = "{{ $activeTab }}"; // from controller
            if (activeTab) {
                const tabEl = document.querySelector(`#${activeTab}-tab`);
                if (tabEl) {
                    const tab = new bootstrap.Tab(tabEl);
                    tab.show();
                }
            }
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const arabicMonths = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر',
                'أكتوبر', 'نوفمبر', 'ديسمبر'
            ];

            // Monthly Orders Count
            new ApexCharts(document.querySelector("#monthlyOrdersCountChart"), {
                chart: {
                    type: 'bar',
                    height: 400
                },
                series: [{
                    name: 'عدد الطلبات',
                    data: @json($ordersByMonthCount)
                }],
                xaxis: {
                    categories: arabicMonths
                },
                yaxis: {
                    title: {
                        text: 'عدد الطلبات'
                    }
                },
                dataLabels: {
                    enabled: true
                },
                colors: ['#1E90FF']
            }).render();

            // Monthly Orders Total
            new ApexCharts(document.querySelector("#monthlyOrdersTotalChart"), {
                chart: {
                    type: 'area',
                    height: 400
                },
                series: [{
                    name: 'إجمالي الطلبات (ر.س)',
                    data: @json($ordersByMonthTotal)
                }],
                xaxis: {
                    categories: arabicMonths
                },
                yaxis: {
                    title: {
                        text: 'إجمالي الطلبات (ر.س)'
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                dataLabels: {
                    enabled: true,
                    formatter: val => val.toLocaleString() + ' ر.س'
                },
                colors: ['#FF9800'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.6,
                        opacityTo: 0.1
                    }
                }
            }).render();
        });
    </script>
@endsection
