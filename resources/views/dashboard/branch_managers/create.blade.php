<x-modals.form modalId="dataEntryModal" formId="dataEntryForm" :action="route('dashboard.branch_managers.store')" title="إضافة مسؤول إدخال بيانات جديد"
    size="modal-lg">

    <input type="hidden" id="record_id" name="id" />

    <div class="row">
        <x-form.input id="full_name" name="full_name" label="الاسم الكامل" required="true" errorId="full_nameError"
            :col="12" />
        <x-form.input id="phone" name="phone" label="رقم الهاتف" required="true" errorId="phoneError" />

        <x-form.input id="email" name="email" label="البريد الالكتروني" errorId="emailError" />

        <x-form.input id="password" name="password" label="كلمة المرور" type="password" required="true"
            errorId="passwordError" />

        <x-form.input id="password_confirmation" name="password_confirmation" label="تأكيد كلمة المرور" type="password"
            required="true" errorId="passwordConfirmationError" />
    </div>

</x-modals.form>
