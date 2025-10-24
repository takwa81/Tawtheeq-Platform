@extends('dashboard.layouts.app')

@section('content')
 <div class="content-header d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="content-title card-title"> تعديل مزود الخدمة </h2>

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
            <form action="{{ route('dashboard.service_owners.update', $user->id) }}" method="POST"
                enctype="multipart/form-data" id="serviceOwnerForm">
                @csrf
                @method('PUT')

                <div class="row">
                    {{-- Basic user fields --}}
                    <x-form.input id="full_name" name="full_name" label="الاسم الكامل" required="true"
                        value="{{ $user->full_name }}" errorId="full_nameError" />

                    <x-form.input id="phone_number" name="phone_number" label="رقم الهاتف" required="true"
                        value="{{ $user->phone_number }}" errorId="phone_numberError" />

                    {{-- Service Owner specific fields --}}
                    <x-form.select id="creator_user_id" name="creator_user_id" label="مسؤول إدخال البيانات"
                        :options="$dataEntryUsers->pluck('full_name', 'id')" :selected="$user->serviceOwner->creator_user_id" errorId="creatorUserIdError" />

                    <x-form.select id="gender" name="gender" label="الجنس" :options="['male' => 'ذكر', 'female' => 'أنثى']" :selected="$user->serviceOwner->gender" />

                    <x-form.select id="academic_qualification_id" name="academic_qualification_id" label="المؤهل الأكاديمي"
                        :options="$academicQualifications->pluck('name_ar', 'id')" :selected="$user->serviceOwner->academic_qualification_id" errorId="academicQualificationError" />

                    <x-form.input id="age" name="age" label="العمر" type="number"
                        value="{{ $user->serviceOwner->age }}" errorId="ageError" />

                    <x-form.input id="email" name="email" label="البريد الإلكتروني" type="email"
                        value="{{ $user->serviceOwner->email }}" errorId="emailError" />

                    <x-form.textarea id="data_entry_note" name="data_entry_note" label="ملاحظات إدخال البيانات"
                        errorId="dataEntryNoteError" col="12">
                        {{ $user->serviceOwner->data_entry_note }}
                    </x-form.textarea>

                    <x-form.file id="personal_image_path" name="personal_image_path" label="الصورة الشخصية"
                        errorId="personalImageError" :previewSrc="$user->serviceOwner->personal_image_path
                            ? $user->serviceOwner->image_url
                            : asset('assets/images/upload.svg')" />

                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">تحديث</button>
                    <a href="{{ route('dashboard.service_owners.index') }}" class="btn btn-secondary">إلغاء</a>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('admin/dashboard/pages/serviceOwner.js') }}"></script>
@endsection
