@extends('dashboard.layouts.app')

@section('content')
    <div class="card mb-4">
        <div class="card-header bg-main text-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-light">تفاصيل مدير الفرع</h5>
        </div>
        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <strong>الاسم الكامل:</strong> {{ $user->full_name }}
                </div>
                <div class="col-md-6">
                    <strong>الهاتف:</strong> {{ $user->phone }}
                </div>
                <div class="col-md-6">
                    <strong>البريد الإلكتروني:</strong> {{ $user->email ?? '-' }}
                </div>
                <div class="col-md-6">
                    <strong>الحالة:</strong>
                    <span class="badge bg-{{ $user->status === 'active' ? 'success' : 'danger' }}">
                       {!! accountStatusBadge($user->status) !!}
                    </span>
                </div>
            </div>

            {{-- الفروع المرتبطة --}}
            <div class="col-12">
                <h6>الفروع المرتبطة:</h6>
                @if ($user->branchManager && $user->branchManager->branches->count())
                    <div class="row g-3">
                        @foreach ($user->branchManager->branches as $branch)
                            <div class="col-md-4 col-sm-6">
                                <div class="card shadow-sm rounded-3 h-100">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $branch->user->full_name ?? '-' }}</strong><br>
                                            <small class="text-muted">{{ $branch->user->phone ?? '-' }}</small>
                                        </div>
                                        <div>
                                            <a href="{{ route('dashboard.branches.show', $branch->user) }}"
                                                class="btn btn-md rounded font-sm bg-secondary text-white"
                                                title="عرض الفرع">
                                                <i class="material-icons md-remove_red_eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>لا توجد فروع مرتبطة.</p>
                @endif
            </div>
        </div>
    </div>
@endsection
