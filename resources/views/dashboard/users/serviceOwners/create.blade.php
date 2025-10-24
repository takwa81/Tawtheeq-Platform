@extends('dashboard.layouts.app')

@section('content')
    <div class="content-header d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="content-title card-title">إضافة مزود خدمة جديد</h2>

        </div>
        <div>
            <a href="javascript:void(0)" onclick="history.back()" class="btn btn-md rounded font-sm">
                <i class="material-icons md-arrow_back"></i>
            </a>
        </div>
    </div>
    <div class="card">
        <div class="card-header bg-main">
            <h5>معلومات مزود الخدمة </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('dashboard.service_owners.store') }}" method="POST" enctype="multipart/form-data"
                id="serviceOwnerForm">
                @csrf

                <div class="row">
                    {{-- Basic user fields --}}
                    <x-form.input id="full_name" name="full_name" label="الاسم الكامل" required="true"
                        errorId="full_nameError" />
                    <x-form.input id="phone_number" name="phone_number" label="رقم الهاتف" required="true"
                        errorId="phone_numberError" />
                    <x-form.input id="password" name="password" label="كلمة المرور" type="password" required="true"
                        errorId="passwordError" />
                    <x-form.input id="password_confirmation" name="password_confirmation" label="تأكيد كلمة المرور"
                        type="password" required="true" errorId="passwordConfirmationError" />

                    {{-- Service Owner specific fields --}}
                    <x-form.select id="creator_user_id" name="creator_user_id" label="مسؤول إدخال البيانات"
                        :options="$dataEntryUsers->pluck('full_name', 'id')" errorId="creatorUserIdError" />

                    <x-form.select id="gender" name="gender" label="الجنس" :options="['male' => 'ذكر', 'female' => 'أنثى']" errorId="genderError" />

                    <x-form.select id="academic_qualification_id" name="academic_qualification_id" label="المؤهل الأكاديمي"
                        :options="$academicQualifications->pluck('name_ar', 'id')" errorId="academicQualificationError" />

                    <x-form.input id="age" name="age" label="العمر" type="number" errorId="ageError" />

                    <x-form.input id="email" name="email" label="البريد الإلكتروني" type="email"
                        errorId="emailError" />
                    <x-form.textarea id="data_entry_note" name="data_entry_note" label="ملاحظات إدخال البيانات"
                        errorId="dataEntryNoteError" col="12" />

                    <x-form.file id="personal_image_path" name="personal_image_path" label="الصورة الشخصية"
                        errorId="personalImageError" />


                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">حفظ</button>
                    <a href="{{ route('dashboard.service_owners.index') }}" class="btn btn-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('scripts')
    <script src="{{ asset('admin/dashboard/pages/serviceOwner.js') }}"></script>
@endsection
