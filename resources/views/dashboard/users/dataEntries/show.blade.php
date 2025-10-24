@extends('dashboard.layouts.app')

@section('content')
    <div class="content-header d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="content-title card-title">تفاصيل مسؤول إدخال بيانات {{ $user->full_name }}</h2>

            <p class="card-title"> الحالة: <strong>{!! accountStatusBadge($user->account_status) !!}</strong></p>
        </div>
        <div>
            <a href="javascript:void(0)" onclick="history.back()" class="btn btn-md rounded font-sm">
                <i class="material-icons md-arrow_back"></i>
            </a>
        </div>

    </div>


    {{-- Basic Information Section --}}
    <div class="card mb-4">
        <div class="card-header bg-main">
            <h5 class="card-title mb-0"><i class="material-icons md-info_outline"></i> البيانات الأساسية</h5>
        </div>
        <div class="card-body">
            <div class="row">

                <div class="col-md-6 mb-3">
                    <i class="material-icons md-person"></i>
                    <span>الاسم الكامل:</span>
                    <strong>{{ $user->full_name }}</strong>
                </div>

                <div class="col-md-6 mb-3">
                    <i class="material-icons md-phone"></i>
                    <span>رقم الهاتف:</span>
                    <strong>{{ $user->phone_number }}</strong>
                </div>

                <div class="col-md-6 mb-3">
                    <i class="material-icons md-calendar_today"></i>
                    <span>تاريخ الإنشاء:</span>
                    <strong>{{ $user->created_at->format('Y-m-d H:i') }}</strong>
                </div>

                <div class="col-md-6 mb-3">
                    <i class="material-icons md-update"></i>
                    <span>آخر تعديل:</span>
                    <strong>{{ $user->updated_at->format('Y-m-d H:i') }}</strong>
                </div>

                @if ($user->deleted_at)
                    <div class="col-md-6 mb-3">
                        <i class="material-icons md-delete_forever"></i>
                        <span>تم الحذف:</span>
                        <strong>{{ $user->deleted_at->format('Y-m-d H:i') }}</strong>
                    </div>
                @endif

            </div>
        </div>
    </div>
@endsection
