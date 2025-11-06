<x-modals.form modalId="dataEntryModal" formId="dataEntryForm" :action="route('dashboard.branches.store')" title="إضافة فرع جديد" size="modal-lg">

    <input type="hidden" id="record_id" name="id" />

    <div class="row">
        <x-form.input id="full_name" name="full_name" label="الاسم الكامل" :col="12" required="true" errorId="full_nameError" />

        <x-form.input id="branch_number" name="branch_number" label="رقم الفرع" required="true" errorId="branch_numberError" />
        <x-form.input id="phone" name="phone" label="رقم الهاتف" required="true" errorId="phoneError" />

        <x-form.input id="password" name="password" label="كلمة المرور" type="password" required="true"
            errorId="passwordError" />

        <x-form.input id="password_confirmation" name="password_confirmation" label="تأكيد كلمة المرور" type="password"
            required="true" errorId="passwordConfirmationError" />
        @php
            $user = auth()->user();
        @endphp

        @if ($user->role === 'super_admin')
            <div class="mb-3 col-md-6">
                <label for="manager_id" class="form-label">مدير الفرع</label>
                <select id="manager_id" name="manager_id" class="form-select">
                    <option value="">اختر مدير الفرع</option>
                    @foreach ($managers as $manager)
                        <option value="{{ $manager->id }}" {{ old('manager_id') == $manager->id ? 'selected' : '' }}>
                            {{ $manager->full_name }}
                        </option>
                    @endforeach
                </select>
                <div class="text-danger" id="manager_idError"></div>
            </div>
        @endif

    </div>

</x-modals.form>
