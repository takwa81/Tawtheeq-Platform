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
        $colClass = $isSuperAdmin ? 'col-md-3' : 'col-md-4';
    @endphp
    <div class="content-header mb-4">
        <h2 class="content-title card-title">لوحة التحكم</h2>
    </div>

    <div class="row g-3 mb-3">
        @if (auth()->user()->role === 'super_admin')
            <div class="col-md-3">
                <div class="card text-center shadow-sm">
                    <div class="card-body">
                        <i class="material-icons md-36 text-success md-supervisor_account"></i>
                        <h5 class="mt-2">عدد المشتركين</h5>
                        <h3>{{ $totalManagersCount }}</h3>
                    </div>
                </div>
            </div>
        @endif
        <div class="{{ $colClass }}">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="material-icons md-36 text-primary md-store"></i>
                    <h5 class="mt-2">عدد الفروع</h5>
                    <h3>{{ $totalBranchesCount }}</h3>
                </div>
            </div>
        </div>
        <div class="{{ $colClass }}">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="material-icons md-36 text-warning md-shopping_cart"></i>
                    <h5 class="mt-2">عدد الطلبات الكلي</h5>
                    <h3>{{ $totalOrdersCount }}</h3>
                </div>
            </div>
        </div>
        <div class="{{ $colClass }}">
            <div class="card text-center shadow-sm">
                <div class="card-body">
                    <i class="material-icons md-36 text-danger md-attach_money"></i>
                    <h5 class="mt-2">إجمالي الطلبات</h5>
                    <h3>{{ number_format($totalOrdersAmount, 2) }}</h3>
                </div>
            </div>
        </div>
    </div>

    <form method="GET" class="row g-2 mb-4">
        <div class="col-md-3">
            <select name="month" class="form-select  bg-white">
                <option value="">اختر الشهر</option>
                @foreach ($arabicMonths as $num => $name)
                    <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>{{ $name }}</option>
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
        <div class="col-md-2">
            <button class="btn btn-primary w-100">تحديث</button>
        </div>
        <div class="col-md-1 mt-2">
            <a href="{{ route('dashboard.home') }}" class="btn text-light w-100 bg-secondary">
                <i class="material-icons md-refresh"></i>
            </a>
        </div>
    </form>

    @if ($month || $year)
        <div class="alert alert-info">
            <strong>نتائج الطلبات :</strong>
            @if ($month)
                لشهر: {{ $arabicMonths[$month] }}
            @endif
            @if ($year)
                سنة: {{ $year }}
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
@endsection
