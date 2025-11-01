<div class="row g-3">
    <div class="col-md-4">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h5>عدد الفروع المرتبطة</h5>
                <h3>{{ $branchesCount }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h5>عدد الطلبات</h5>
                <h3>{{ $ordersCount }}</h3>
            </div>
        </div>
    </div>

    <div class="col-md-4">
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

{{-- Optionally show list of branches --}}
<div class="mt-4">
    <h5>الفروع المرتبطة:</h5>
    @if(auth()->user()->branchManager && auth()->user()->branchManager->branches->count())
        <ul class="list-group">
            @foreach(auth()->user()->branchManager->branches as $branch)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    {{ $branch->user->full_name ?? '-' }}
                    <span class="badge bg-primary rounded-pill">ID: {{ $branch->id }}</span>
                </li>
            @endforeach
        </ul>
    @else
        <p>لا توجد فروع مرتبطة.</p>
    @endif
</div>
