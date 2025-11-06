@extends('dashboard.layouts.app')
@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css"
        rel="stylesheet" />

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <style>
        .form-check-input.form-check-input:checked {
            background-color: #572972 !important;
        }

        .form-check-input {
            width: 1.3em;
            height: 1.3em;
        }

        .form-check {
            width: 60%;
        }

        #serviceMap {
            height: 300px;
            margin-bottom: 20px;
        }
    </style>
@endsection
@section('content')
    <div class="content-header d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="content-title card-title">إضافة طلب جديد</h2>
        </div>
        <div>
            <a href="javascript:void(0)" onclick="history.back()" class="btn btn-md rounded font-sm">
                <i class="material-icons md-arrow_back"></i>
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-main">
            <h5 class="text-light">معلومات الطلب</h5>
        </div>
        <div class="card-body">
            <form id="orderForm" action="{{ route('dashboard.orders.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row g-3">

                        <x-form.select id="company_id" name="company_id" label="شركة التوصيل" :options="$companies->pluck('name_ar', 'id')->toArray()"
                            col="6" />

                        <x-form.input id="order_number" name="order_number" :label="__('dashboard.order_number')" errorId="order_numberError"  placeholder="#1234"  required="true"/>

                        <x-form.input id="total_order" name="total_order" :label="__('dashboard.total_order')" required="true"
                            errorId="total_orderError" :col="12" type="number" step="0.01" min="0" placeholder="0.00"/>


                        <x-form.input id="date" name="date" :label="__('dashboard.date')" type="date" required="true"
                            errorId="dateError" />

                        <x-form.input id="time" name="time" :label="__('dashboard.time')" type="time" required="true"
                            errorId="timeError" />
                        <x-form.input id="driver_name" name="driver_name" :label="__('dashboard.driver_name')" type="driver_name"
                            errorId="driver_nameError"  placeholder="اسم المندوب (السائق)"/>
                        <x-form.input id="customer_name" name="customer_name" :label="__('dashboard.customer_name')" type="customer_name"
                            errorId="customer_nameError"  placeholder="الاسم"/>

                        <x-form.input id="customer_phone" name="customer_phone" :label="__('dashboard.customer_phone')" type="customer_phone"
                            errorId="customer_phoneError" placeholder="الرقم " />

                        <x-form.file id="order_image" name="order_image" :label="__('dashboard.order_image')" errorId="order_imageError"  required="true"
                            previewSrc="{{ asset('assets/images/upload.svg') }}" />

                        <x-form.textarea id="notes" name="notes" :label="__('dashboard.notes')" :col="12" />

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                </div>
            </form>
        </div>
    </div>
@endsection


@section('scripts')
    <script src="{{ asset('admin/dashboard/pages/orders.js') }}"></script>
@endsection
