$arabicMonths = [
    1=>'يناير',2=>'فبراير',3=>'مارس',4=>'أبريل',5=>'مايو',6=>'يونيو',
    7=>'يوليو',8=>'أغسطس',9=>'سبتمبر',10=>'أكتوبر',11=>'نوفمبر',12=>'ديسمبر'
];
@endphp
<div class="row g-3">
    <div class="col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <i class="material-icons md-36 text-primary md-store"></i>
                <h5 class="mt-2">عدد الفروع</h5>
                <h3>{{ $branchesCount }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <i class="material-icons md-36 text-success md-supervisor_account"></i>
                <h5 class="mt-2">عدد المدراء</h5>
                <h3>{{ $managersCount }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <i class="material-icons md-36 text-warning md-shopping_cart"></i>
                <h5 class="mt-2">عدد الطلبات</h5>
                <h3>{{ $ordersCount }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <i class="material-icons md-36 text-danger md-attach_money"></i>
                <h5 class="mt-2">إجمالي الطلبات (ر.س)</h5>
                <h3>{{ number_format($ordersTotal, 2) }}</h3>
            </div>
        </div>
    </div>
</div>


<form method="GET" class="row g-2 mb-4">
    <div class="col-md-3">
        <select name="month" class="form-select">
            <option value="">اختر الشهر</option>
            @foreach($arabicMonths as $num => $name)
                <option value="{{ $num }}" {{ $month == $num ? 'selected' : '' }}>{{ $name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-3">
        <select name="year" class="form-select">
            <option value="">اختر السنة</option>
            @foreach(range(date('Y'), date('Y')-5) as $y)
                <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100">تحديث</button>
    </div>
</form>


<div class="row g-3">
    <div class="col-md-6">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <i class="material-icons md-36 text-warning">shopping_cart</i>
                <h5 class="mt-2">عدد الطلبات</h5>
                <h3>{{ $ordersCount }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <i class="material-icons md-36 text-danger">attach_money</i>
                <h5 class="mt-2">إجمالي الطلبات (ر.س)</h5>
                <h3>{{ number_format($ordersTotal, 2) }}</h3>
            </div>
        </div>
    </div>
</div>
