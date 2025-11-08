@extends('dashboard.layouts.app')

@section('content')
    @php
        $months = __('dashboard.months');
    @endphp

    @php
        $isSuperAdmin = auth()->user()->role === 'super_admin';
        $isBranchManager = auth()->user()->role === 'branch_manager';
        $isBranch = auth()->user()->role === 'branch';
        if ($isSuperAdmin) {
            $colClass = 'col-md-3';
        } elseif ($isBranchManager) {
            $colClass = 'col-md-4';
        } else {
            $colClass = 'col-md-6';
        }
    @endphp
    <div class="content-header mb-4">
        <h2 class="content-title card-title">{{ __('dashboard.home') }}</h2>
    </div>

    <div class="row g-3 mb-3">
        @if (auth()->user()->role === 'super_admin')
            <div class="col-md-3">
                <a href="{{ route('dashboard.branch_managers.index') }}">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <i class="material-icons md-36 text-success md-supervisor_account"></i>
                            <h5 class="mt-2">{{ __('dashboard.total_branch_managers') }}</h5>
                            <h3>{{ $totalManagersCount }}</h3>
                        </div>
                    </div>
                </a>
            </div>
        @endif
        @if (auth()->user()->role === 'super_admin' || auth()->user()->role === 'branch_manager')
            <div class="{{ $colClass }}">
                <a href="{{ route('dashboard.branches.index') }}">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <i class="material-icons md-36 text-primary md-store"></i>
                            <h5 class="mt-2">{{ __('dashboard.total_branches') }}</h5>
                            <h3>{{ $totalBranchesCount }}</h3>
                        </div>
                    </div>
                </a>
            </div>
        @endif
        <div class="{{ $colClass }}">
            <a class="{{ route('dashboard.orders.index') }}">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <i class="material-icons md-36 text-warning md-shopping_cart"></i>
                        <h5 class="mt-2">{{ __('dashboard.total_orders_count') }}</h5>
                        <h3>{{ $totalOrdersCount }}</h3>
                    </div>
                </div>
            </a>
        </div>
        <div class="{{ $colClass }}">
            <a class="{{ route('dashboard.orders.index') }}">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <i class="material-icons md-36 text-danger md-attach_money"></i>
                        <h5 class="mt-2">{{ __('dashboard.total_orders_amount') }}</h5>
                        <h3>{{ number_format($totalOrdersAmount, 2) }}</h3>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-3">
            <select name="month" class="form-select  bg-white">
                <option value="">{{ __('dashboard.select_month') }}</option>
                @foreach ($months as $num => $name)
                    <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>{{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="year" class="form-select  bg-white">
                <option value="">{{ __('dashboard.select_year') }}<< /option>
                        @foreach (range(date('Y'), date('Y') - 5) as $y)
                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        @if ($isSuperAdmin || $isBranchManager)
            <div class="col-md-3">
                <select name="branch_id" class="form-select bg-white">
                    <option value="">{{ __('dashboard.select_branch') }}</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" {{ $branchId == $branch->id ? 'selected' : '' }}>
                            {{ $branch->user?->full_name ?? '---' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="company_id" class="form-select bg-white">
                    <option value="">{{ __('dashboard.select_company') }}</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->name }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="col-md-2">
            <button class="btn btn-primary w-100">{{ __('dashboard.update') }}</button>
        </div>
        <div class="col-md-1 mt-2">
            <a href="{{ route('dashboard.home') }}" class="btn text-light w-100 bg-secondary"
                title="{{ __('dashboard.reset') }}">
                <i class="material-icons md-refresh"></i>
            </a>
        </div>
    </form>

    @if ($month || $year || $companyId || $branchId)
        <div class="alert alert-info">
            <strong>{{ __('dashboard.order_results') }} :</strong>

            @if ($month)
                {{ __('dashboard.for_month') }}: {{ $months[$month] }}
            @endif

            @if ($year)
                {{ __('dashboard.for_year') }}: {{ $year }}
            @endif

            @if ($companyId)
                @php
                    $selectedCompany = $companies->firstWhere('id', $companyId);
                @endphp
                @if ($selectedCompany)
                    — {{ __('dashboard.company') }}: {{ $selectedCompany->name }}
                @endif
            @endif

            @if ($branchId)
                @php
                    $selectedBranch = $branches->firstWhere('id', $branchId);
                @endphp
                @if ($selectedBranch)
                    — {{ __('dashboard.branch') }}: {{ $selectedBranch->user?->full_name ?? '---' }}
                @endif
            @endif
        </div>

    @endif



    <div class="row g-3">
        <div class="col-md-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="material-icons md-36 text-warning md-shopping_cart"></i>
                    <h5 class="mt-2">{{ __('dashboard.orders_count') }}</h5>
                    <h3>{{ $ordersCount }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="material-icons md-36 text-danger md-attach_money"></i>
                    <h5 class="mt-2">{{ __('dashboard.orders_total') }} ({{ __('dashboard.currency') }})</h5>
                    <h3>{{ number_format($ordersTotal, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>


    <div class="row g-3 mt-3">

        <div class="col-md-6">
            <div class="card card-body">
                <h5>{{ __('dashboard.monthly_orders_count', ['year' => $year]) }}</h5>
                <div id="monthlyOrdersCountChart" style="height: 400px;"></div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card card-body">
                <h5>{{ __('dashboard.monthly_orders_total', ['year' => $year, 'currency' => __('dashboard.currency')]) }}
                </h5>
                <div id="monthlyOrdersTotalChart" style="height: 400px;"></div>
            </div>
        </div>

    </div>


    {{-- Charts --}}
    <div class="row g-3">

        <div class="col-md-12">
            <div class="card card-body">
                <h5>{{ __('dashboard.branch_total_sales', ['year' => $year, 'currency' => __('dashboard.currency')]) }}
                </h5>
                <div id="branchTotalOrderChart" style="height: 400px;"></div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card card-body">
                <h5>{{ __('dashboard.branch_orders_count', ['year' => $year]) }}</h5>
                <div id="ordersSplineChart" style="height: 400px;"></div>
            </div>
        </div>

        {{-- @if ($isSuperAdmin) --}}
        <div class="col-md-12 mt-3">
            <div class="card card-body">
                <h5>{{ __('dashboard.company_orders_count', ['year' => $year]) }}</h5>
                <div id="companyOrdersBarChart" style="height: 400px;"></div>
            </div>
        </div>
        {{-- @endif --}}

    </div>


@endsection

@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            new ApexCharts(document.querySelector("#ordersSplineChart"), {
                chart: {
                    type: 'bar',
                    height: 400,
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: false,
                            zoom: false,
                            zoomin: false,
                            zoomout: false,
                            pan: false,
                            reset: false
                        }
                    }
                },
                series: [{
                    name: '{{ __('dashboard.orders_count') }}',
                    data: @json($branchData)
                }],
                xaxis: {
                    categories: @json($branchLabels),
                    title: {
                        text: '{{ __('dashboard.branches') }}'
                    }
                },
                yaxis: {
                    title: {
                        text: '{{ __('dashboard.orders_count') }}'
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        borderRadius: 6
                    }
                },
                dataLabels: {
                    enabled: true
                },
                colors: ['#1E90FF'],
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " {{ __('dashboard.order') }}";
                        }
                    }
                }
            }).render();

            new ApexCharts(document.querySelector("#branchTotalOrderChart"), {
                chart: {
                    type: 'area', // spline chart
                    height: 400,
                    toolbar: {
                        show: true, // تظهر الأدوات
                        tools: {
                            download: true, // زر تحميل المخطط كصورة
                            selection: false,
                            zoom: false,
                            zoomin: false,
                            zoomout: false,
                            pan: false,
                            reset: false
                        }
                    }
                },
                series: [{
                    name: '{{ __('dashboard.total_sales') }} ({{ __('dashboard.currency') }})',
                    data: @json($totalBranchData)
                }],
                xaxis: {
                    categories: @json($totalBranchLabels),
                    title: {
                        text: '{{ __('dashboard.branches') }}'
                    }
                },
                yaxis: {
                    title: {
                        text: '{{ __('dashboard.total_sales') }} ({{ __('dashboard.currency') }})'
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val.toLocaleString() + ' {{ __('dashboard.currency') }}';
                    }
                },
                colors: ['#FF9800'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.6,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val.toLocaleString() + ' {{ __('dashboard.currency') }}';
                        }
                    }
                }
            }).render();



            new ApexCharts(document.querySelector("#companyOrdersBarChart"), {
                chart: {
                    type: 'bar',
                    height: 400,
                    toolbar: {
                        show: true,
                        tools: {
                            download: true, // زر تحميل PNG
                            selection: false,
                            zoom: false,
                            zoomin: false,
                            zoomout: false,
                            pan: false,
                            reset: false
                        }
                    }
                },
                series: [{
                    name: '{{ __('dashboard.orders_count') }}',
                    data: @json($companyOrders) // عدد الطلبات لكل شركة
                }],
                xaxis: {
                    categories: @json($companyNames), // أسماء الشركات
                    title: {
                        text: '{{ __('dashboard.companies') }}'
                    }
                },
                yaxis: {
                    title: {
                        text: '{{ __('dashboard.orders_count') }}'
                    }
                },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: '55%',
                        borderRadius: 6
                    }
                },
                dataLabels: {
                    enabled: true
                },
                colors: ['#00BFFF'],
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " {{ __('dashboard.order') }}";
                        }
                    }
                }
            }).render();

        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const months = @json(array_values(__('dashboard.months')));

            // Monthly Orders Count (Bar chart)
            new ApexCharts(document.querySelector("#monthlyOrdersCountChart"), {
                chart: {
                    type: 'bar',
                    height: 400,
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: false,
                            zoom: false,
                            zoomin: false,
                            zoomout: false,
                            pan: false,
                            reset: false
                        }
                    }
                },
                series: [{
                    name: '{{ __('dashboard.orders_count') }}',
                    data: @json($ordersByMonthCount)
                }],
                xaxis: {
                    categories: months,
                    title: {
                        text: '{{ __('dashboard.months_title') }}'
                    }
                },
                yaxis: {
                    title: {
                        text: '{{ __('dashboard.orders_count') }}'
                    }
                },
                plotOptions: {
                    bar: {
                        columnWidth: '55%',
                        borderRadius: 6
                    }
                },
                dataLabels: {
                    enabled: true
                },
                colors: ['#1E90FF'],
                tooltip: {
                    y: {
                        formatter: val => val + ' {{ __('dashboard.order') }}'
                    }
                }
            }).render();

            // Monthly Orders Total (Area/Spline chart)
            new ApexCharts(document.querySelector("#monthlyOrdersTotalChart"), {
                chart: {
                    type: 'area',
                    height: 400,
                    toolbar: {
                        show: true,
                        tools: {
                            download: true,
                            selection: false,
                            zoom: false,
                            zoomin: false,
                            zoomout: false,
                            pan: false,
                            reset: false
                        }
                    }
                },
                series: [{
                    name: '{{ __('dashboard.total_orders') }} ({{ __('dashboard.currency') }})',
                    data: @json($ordersByMonthTotal)
                }],
                xaxis: {
                    categories: months,
                    title: {
                        text: '{{ __('dashboard.months_title') }}'
                    }
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
                    formatter: val => val.toLocaleString() + ' {{ __('dashboard.currency') }}'
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.6,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                },
                colors: ['#FF9800'],
                tooltip: {
                    y: {
                        formatter: val => val.toLocaleString() + ' {{ __('dashboard.currency') }}'
                    }
                }
            }).render();

        });
    </script>
@endsection
