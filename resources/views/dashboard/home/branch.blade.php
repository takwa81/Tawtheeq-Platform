<div class="row g-3">
    <div class="col-md-6">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h5>عدد الطلبات للفرع</h5>
                <h3>{{ $ordersCount }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h5>إجمالي الطلبات (ر.س)</h5>
                <h3>{{ number_format($ordersTotal, 2) }}</h3>
            </div>
        </div>
    </div>
</div>

{{-- Filter by month/year --}}
<form method="GET" class="row g-2 mt-3">
    <div class="col-md-3">
        <input type="number" name="month" class="form-control" placeholder="شهر" value="{{ $month }}">
    </div>
    <div class="col-md-3">
        <input type="number" name="year" class="form-control" placeholder="سنة" value="{{ $year }}">
    </div>
    <div class="col-md-2">
        <button class="btn btn-primary w-100">تحديث</button>
    </div>
</form>
