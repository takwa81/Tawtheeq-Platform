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

    <div class="content-header d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="content-title card-title">{{ __('dashboard.branch_details') }} ({{ $branch->full_name }})</h2>
        </div>
        <div>
            <a href="javascript:void(0)" onclick="history.back()" class="btn btn-md rounded font-sm">
                <i class="material-icons md-arrow_back"></i>
            </a>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header bg-main">
            <h5 class="text-light">{{ __('dashboard.branch_details') }}</h5>
        </div>
        <div class="card-body">

            {{-- Tabs --}}
            <ul class="nav nav-tabs" id="branchTab" role="tablist">
                <li class="nav-item mx-1.5 p-1" role="presentation">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info"
                        type="button" role="tab">
                        <i class="material-icons md-18 me-1 md-info"></i> {{ __('dashboard.branch_info') }}
                    </button>
                </li>
                <li class="nav-item mx-1.5 p-1" role="presentation">
                    <button class="nav-link" id="orders-tab" data-bs-toggle="tab" data-bs-target="#orders" type="button"
                        role="tab">
                        <i class="material-icons md-18 me-1 md-shopping_cart"></i> {{ __('dashboard.orders') }}
                    </button>
                </li>
                <li class="nav-item mx-1.5 p-1" role="presentation">
                    <button class="nav-link" id="stats-tab" data-bs-toggle="tab" data-bs-target="#stats" type="button"
                        role="tab">
                        <i class="material-icons md-18 me-1 md-bar_chart"></i> {{ __('dashboard.statistics') }}
                    </button>
                </li>
            </ul>

            <div class="tab-content mt-3" id="branchTabContent">

                {{-- معلومات الفرع --}}
                <div class="tab-pane fade show active" id="info" role="tabpanel">
                    <div class="row g-3">
                        <div class="col-md-6"><strong>{{ __('dashboard.branch_name') }}:</strong> {{ $branch->full_name }}
                        </div>
                        <div class="col-md-6"><strong>{{ __('dashboard.branch_number') }}:</strong>
                            {{ $branch->branch->branch_number }}</div>
                        <div class="col-md-6"><strong>{{ __('dashboard.phone_number') }}:</strong> {{ $branch->phone }}
                        </div>
                        <div class="col-md-6">
                            <strong>{{ __('dashboard.status') }}:</strong>
                            <span class="badge bg-{{ $branch->status === 'active' ? 'success' : 'danger' }}">
                                {!! accountStatusBadge($branch->status) !!}
                            </span>
                        </div>
                        <div class="col-md-6"><strong>{{ __('dashboard.branch_manager') }}:</strong>
                            {{ $branch->branch->manager->user->full_name ?? '-' }}</div>
                        <div class="col-md-6">
                            <strong>{{ __('dashboard.orders_count') }}:</strong> {{ $ordersCount }} |
                            <strong>{{ __('dashboard.orders_total') }}:</strong> {{ number_format($ordersTotal, 2) }}
                            {{ __('dashboard.currency') }}
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
                                        <th>{{ __('dashboard.order_number') }}</th>
                                        <th>{{ __('dashboard.company') }}</th>
                                        <th>{{ __('dashboard.amount') }}</th>
                                        <th>{{ __('dashboard.date') }}</th>
                                        <th>{{ __('dashboard.time') }}</th>
                                        <th>{{ __('dashboard.status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($orders as $order)
                                        <tr>
                                            <td>{{ $order->order_number }}</td>
                                            <td>{{ $order->company->name ?? '-' }}</td>
                                            <td>{{ number_format($order->total_order, 2) }} {{ __('dashboard.currency') }}
                                            </td>
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
                                <b class="my-2 mx-3">{{ __('dashboard.total_count') }}: {{ $orders->total() }}</b>
                                <nav aria-label="Page navigation example">
                                    {{ $orders->appends(['tab' => 'orders'])->links() }}
                                </nav>
                            </div>
                        </div>
                    @else
                        <p>{{ __('dashboard.no_orders') }}</p>
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
                                        {{ $y }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </form>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="card card-body">
                                <h5>{{ __('dashboard.monthly_orders_count', ['year' => $year]) }}</h5>
                                <div id="monthlyOrdersCountChart" style="height: 400px;"></div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card card-body">
                                <h5>{{ __('dashboard.monthly_orders_total', ['year' => $year]) }}</h5>
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
            const months = @json(array_values(__('dashboard.months')));


            // Monthly Orders Count
            new ApexCharts(document.querySelector("#monthlyOrdersCountChart"), {
                chart: {
                    type: 'bar',
                    height: 400
                },
                series: [{
                    name: '{{ __('dashboard.orders_count') }}',
                    data: @json($ordersByMonthCount)
                }],
                xaxis: {
                    categories: months
                },
                yaxis: {
                    title: {
                        text: '{{ __('dashboard.orders_count') }}'
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
                    name: '{{ __('dashboard.total_orders') }} ({{ __('dashboard.currency') }})',
                    data: @json($ordersByMonthTotal)
                }],
                xaxis: {
                    categories: months
                },
                yaxis: {
                    title: {
                        text: '{{ __('dashboard.total_orders') }} ({{ __('dashboard.currency') }})'
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                dataLabels: {
                    enabled: true,
                    formatter: val => val.toLocaleString() + '{{ __('dashboard.currency') }}'
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
