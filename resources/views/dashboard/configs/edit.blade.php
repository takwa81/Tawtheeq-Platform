@extends('dashboard.layouts.app')

@section('content')
    <div class="content-header d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="content-title card-title">تعديل الإعدادات العامة</h2>
        </div>
        <div>
            <a href="javascript:void(0)" onclick="history.back()" class="btn btn-md rounded font-sm">
                <i class="material-icons md-arrow_back"></i>
            </a>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-main">
            <h5>الإعدادات </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.configs.update') }}" method="POST"
                enctype="multipart/form-data" id="configForm">
                @csrf

                <div class="row">
                    {{-- Names --}}
                    <x-form.input id="version_app" name="version_app" label="نسخة التطبيق" required="true"
                        :value="$config->version_app" />
               
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">تحديث</button>
                </div>
            </form>
        </div>
    </div>
@endsection

