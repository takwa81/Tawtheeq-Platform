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

    <div class="row g-3 mt-3">

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


    {{-- Charts --}}
    <div class="row g-3">
        <div class="col-md-12">
            <div class="card card-body">
                <h5>إجمالي المبيعات لكل فرع ({{ $year }})</h5>
                <div id="branchTotalOrderChart" style="height: 400px;"></div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card card-body">
                <h5>عدد الطلبات لكل فرع ({{ $year }})</h5>
                <div id="ordersSplineChart" style="height: 400px;"></div>
            </div>
        </div>

        {{-- @if ($isSuperAdmin) --}}
            <div class="col-md-12 mt-3">
                <div class="card card-body">
                    <h5>عدد الطلبات لكل شركة ({{ $year }})</h5>
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
                    type: 'bar', // تم التغيير من area/spline إلى bar
                    height: 400,
                    toolbar: {
                        show: true, // لإظهار أدوات التحميل
                        tools: {
                            download: true, // زر تحميل الصورة
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
                    name: 'عدد الطلبات',
                    data: @json($branchData) // بيانات عدد الطلبات لكل فرع
                }],
                xaxis: {
                    categories: @json($branchLabels), // أسماء الفروع
                    title: {
                        text: 'الفروع'
                    }
                },
                yaxis: {
                    title: {
                        text: 'عدد الطلبات'
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
                            return val + " طلب";
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
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 3
                },
                dataLabels: {
                    enabled: true,
                    formatter: function(val) {
                        return val.toLocaleString() + ' ر.س';
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
                            return val.toLocaleString() + ' ر.س';
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
                    name: 'عدد الطلبات',
                    data: @json($companyOrders) // عدد الطلبات لكل شركة
                }],
                xaxis: {
                    categories: @json($companyNames), // أسماء الشركات
                    title: {
                        text: 'الشركات'
                    }
                },
                yaxis: {
                    title: {
                        text: 'عدد الطلبات'
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
                            return val + " طلب";
                        }
                    }
                }
            }).render();

        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const arabicMonths = ['يناير', 'فبراير', 'مارس', 'أبريل', 'مايو', 'يونيو', 'يوليو', 'أغسطس', 'سبتمبر',
                'أكتوبر', 'نوفمبر', 'ديسمبر'
            ];

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
                    name: 'عدد الطلبات',
                    data: @json($ordersByMonthCount)
                }],
                xaxis: {
                    categories: arabicMonths,
                    title: {
                        text: 'الشهور'
                    }
                },
                yaxis: {
                    title: {
                        text: 'عدد الطلبات'
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
                        formatter: val => val + ' طلب'
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
                    name: 'إجمالي الطلبات (ر.س)',
                    data: @json($ordersByMonthTotal)
                }],
                xaxis: {
                    categories: arabicMonths,
                    title: {
                        text: 'الشهور'
                    }
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
                        formatter: val => val.toLocaleString() + ' ر.س'
                    }
                }
            }).render();

        });
    </script>
@endsection
