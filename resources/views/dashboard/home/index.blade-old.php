@extends('dashboard.layouts.app')

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
        <h2 class="content-title card-title">لوحة التحكم</h2>
    </div>

    <div class="row g-3 mb-3">
        @if (auth()->user()->role === 'super_admin')
            <div class="col-md-3">
                <a href="{{ route('dashboard.branch_managers.index') }}">
                    <div class="card text-center shadow-sm">
                        <div class="card-body">
                            <i class="material-icons md-36 text-success md-supervisor_account"></i>
                            <h5 class="mt-2">عدد المشتركين (البراندات)</h5>
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
                            <h5 class="mt-2">عدد الفروع</h5>
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
                        <h5 class="mt-2">عدد الطلبات الكلي</h5>
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
                        <h5 class="mt-2">إجمالي الطلبات</h5>
                        <h3>{{ number_format($totalOrdersAmount, 2) }}</h3>
                    </div>
                </div>
            </a>
        </div>

    </div>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-3">
            <select name="month" class="form-select  bg-white">
                <option value="">اختر الشهر</option>
                @foreach ($arabicMonths as $num => $name)
                    <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>{{ $name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="year" class="form-select  bg-white">
                <option value="">اختر السنة</option>
                @foreach (range(date('Y'), date('Y') - 5) as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                @endforeach
            </select>
        </div>
        @if ($isSuperAdmin || $isBranchManager)
            <div class="col-md-3">
                <select name="branch_id" class="form-select bg-white">
                    <option value="">اختر الفرع</option>
                    @foreach ($branches as $branch)
                        <option value="{{ $branch->id }}" {{ $branchId == $branch->id ? 'selected' : '' }}>
                            {{ $branch->user?->full_name ?? '---' }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-3">
                <select name="company_id" class="form-select bg-white">
                    <option value="">اختر الشركة</option>
                    @foreach ($companies as $company)
                        <option value="{{ $company->id }}" {{ request('company_id') == $company->id ? 'selected' : '' }}>
                            {{ $company->name_ar }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif

        <div class="col-md-2">
            <button class="btn btn-primary w-100">تحديث</button>
        </div>
        <div class="col-md-1 mt-2">
            <a href="{{ route('dashboard.home') }}" class="btn text-light w-100 bg-secondary">
                <i class="material-icons md-refresh"></i>
            </a>
        </div>
    </form>

    @if ($month || $year || $companyId || $branchId)
        <div class="alert alert-info">
            <strong>نتائج الطلبات :</strong>
            @if ($month)
                لشهر: {{ $arabicMonths[$month] }}
            @endif
            @if ($year)
                سنة: {{ $year }}
            @endif
            @if ($companyId)
                @php
                    $selectedCompany = $companies->firstWhere('id', $companyId);
                @endphp
                @if ($selectedCompany)
                    — الشركة: {{ $selectedCompany->name_ar }}
                @endif
            @endif
            @if ($branchId)
                @php
                    $selectedBranch = $branches->firstWhere('id', $branchId);
                @endphp
                @if ($selectedBranch)
                    — الفرع: {{ $selectedBranch->user?->full_name ?? '---' }}
                @endif
            @endif
        </div>
    @endif



    <div class="row g-3">
        <div class="col-md-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="material-icons md-36 text-warning md-shopping_cart"></i>
                    <h5 class="mt-2">عدد الطلبات</h5>
                    <h3>{{ $ordersCount }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="material-icons md-36 text-danger md-attach_money"></i>
                    <h5 class="mt-2">إجمالي الطلبات (ر.س)</h5>
                    <h3>{{ number_format($ordersTotal, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>


    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title mb-3">💰 إجمالي المبيعات لكل فرع</h4>
            <div id="branchTotalOrderChart" style="height: 400px;"></div>
        </div>
    </div>


    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title mb-3">💰 إجمالي المبيعات لكل شركة</h4>
            <div id="revenueByCompanyChart"></div>
        </div>
    </div>

    <div class="card mt-4 shadow-sm">
        <div class="card-body">
            <h5 class="card-title text-center mb-3">📦 عدد الطلبات لكل شركة</h5>
            <div id="companyOrdersBarChart" style="height: 400px;"></div>
        </div>
    </div>

    @if ($isSuperAdmin)
        <div class="card mt-4 shadow-sm">
            <div class="card-body">
                <h5 class="card-title text-center mb-3">إحصائية الطلبات حسب الأشهر ({{ $year ?? date('Y') }})</h5>
                <canvas id="ordersByMonthChart" height="120"></canvas>
            </div>
        </div>
    @endif

    <div class="card mt-4">
        <div class="card-body">
            <h4 class="card-title mb-3">📈 إحصائية الطلبات لكل فرع</h4>
            <div id="ordersSplineChart" style="height: 400px;"></div>
        </div>
    </div>

@endsection
@section('scripts')
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @if ($isSuperAdmin)
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
            const ctx = document.getElementById('ordersByMonthChart').getContext('2d');
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: @json(array_values($arabicMonths)),
                    datasets: [{
                        label: 'عدد الطلبات',
                        data: @json($ordersByMonth),
                        backgroundColor: 'rgba(0, 193, 202, 0.6)',
                        borderColor: 'rgba(0, 193, 202, 1)',
                        borderWidth: 1,
                        borderRadius: 6,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        </script>
    @endif
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                chart: {
                    type: 'area',
                    height: 400,
                    toolbar: {
                        show: false
                    }
                },
                stroke: {
                    curve: 'smooth'
                },
                dataLabels: {
                    enabled: true
                },
                series: [{
                    name: 'عدد الطلبات',
                    data: @json($chartData)
                }],
                xaxis: {
                    categories: @json($chartLabels),
                    title: {
                        text: 'الفروع'
                    }
                },
                yaxis: {
                    title: {
                        text: 'عدد الطلبات'
                    }
                },
                colors: ['#1E90FF'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.5,
                        opacityTo: 0.1,
                        stops: [0, 90, 100]
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val + " طلب";
                        }
                    }
                }
            };

            var chart = new ApexCharts(document.querySelector("#ordersSplineChart"), options);
            chart.render();
        });
    </script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var totalBranchOptions = {
                chart: {
                    type: 'bar',
                    height: 400,
                    toolbar: {
                        show: false
                    }
                },
                plotOptions: {
                    bar: {
                        borderRadius: 6,
                        horizontal: false,
                        columnWidth: '55%',
                    }
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val.toLocaleString() + ' ر.س';
                    }
                },
                series: [{
                    name: 'إجمالي المبيعات (ر.س)',
                    data: @json($totalBranchData)
                }],
                xaxis: {
                    categories: @json($totalBranchLabels),
                    title: {
                        text: 'الفروع'
                    }
                },
                yaxis: {
                    title: {
                        text: 'إجمالي المبيعات (ر.س)'
                    },
                    labels: {
                        formatter: function(val) {
                            return val.toLocaleString();
                        }
                    }
                },
                colors: ['#FF9800'],
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val.toLocaleString() + ' ر.س';
                        }
                    }
                }
            };

            new ApexCharts(document.querySelector("#branchTotalOrderChart"), totalBranchOptions).render();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Donut Chart for Total Sales
            var donutOptions = {
                chart: {
                    type: 'donut',
                    height: 400
                },
                labels: @json($companyNames),
                series: @json($companySales),
                colors: ['#008FFB', '#00E396', '#FEB019', '#FF4560', '#775DD0'],
                legend: {
                    position: 'bottom'
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val.toFixed(1) + "%";
                    }
                },
                tooltip: {
                    y: {
                        formatter: function(val) {
                            return val.toLocaleString() + " ر.س";
                        }
                    }
                },
                plotOptions: {
                    pie: {
                        donut: {
                            size: '70%',
                            labels: {
                                show: true,
                                total: {
                                    show: true,
                                    label: 'الإجمالي',
                                    formatter: function(w) {
                                        const total = w.globals.seriesTotals.reduce((a, b) => a + b, 0);
                                        return total.toLocaleString() + ' ر.س';
                                    }
                                }
                            }
                        }
                    }
                }
            };
            new ApexCharts(document.querySelector("#companySalesDonutChart"), donutOptions).render();

        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var options = {
                chart: {
                    type: 'bar',
                    height: 400
                },
                series: [{
                    name: 'عدد الطلبات',
                    data: @json($companyOrders)
                }],
                xaxis: {
                    categories: @json($companyNames),
                    title: {
                        text: 'الشركات'
                    }
                },
                yaxis: {
                    title: {
                        text: 'عدد الطلبات'
                    }
                },
                colors: ['#00BFFF'],
                dataLabels: {
                    enabled: true
                }
            };
            new ApexCharts(document.querySelector("#companyOrdersBarChart"), options).render();
        });
    </script>
    <script>
document.addEventListener("DOMContentLoaded", function() {
    var options = {
        chart: { type: 'bar', height: 400 },
        plotOptions: {
            bar: { horizontal: false, columnWidth: '55%', borderRadius: 8 }
        },
        dataLabels: { enabled: true },
        series: [{
            name: 'إجمالي المبيعات',
            data: @json($revenueData)
        }],
        xaxis: {
            categories: @json($revenueLabels),
            title: { text: 'الشركات' }
        },
        yaxis: {
            title: { text: 'المبيعات (ر.س)' }
        },
        colors: ['#FF8C00'],
    };
    new ApexCharts(document.querySelector("#revenueByCompanyChart"), options).render();
});
</script>
@endsection
