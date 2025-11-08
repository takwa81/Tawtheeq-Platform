<x-modals.form modalId="dataEntryModal" formId="dataEntryForm" :action="route('dashboard.branches.store')"
    title="{{ __('dashboard.add_new_branch') }}" size="modal-lg">

    <input type="hidden" id="record_id" name="id" />

    <div class="row">
        <x-form.input id="full_name" name="full_name" label="{{ __('dashboard.full_name') }}" :col="12"
            required="true" errorId="full_nameError" />

        <x-form.input id="branch_number" name="branch_number" label="{{ __('dashboard.branch_number') }}"
            required="true" errorId="branch_numberError" />

        <x-form.input id="phone" name="phone" label="{{ __('dashboard.phone_number') }}" required="true"
            errorId="phoneError" />

        <x-form.input id="password" name="password" label="{{ __('dashboard.password') }}" type="password"
            required="true" errorId="passwordError" />

        <x-form.input id="password_confirmation" name="password_confirmation"
            label="{{ __('dashboard.confirm_password') }}" type="password" required="true"
            errorId="passwordConfirmationError" />

        @php
            $user = auth()->user();
        @endphp

        @if ($user->role === 'super_admin')
            <div class="mb-3 col-md-6">
                <label for="manager_id" class="form-label">{{ __('dashboard.branch_manager') }}</label>
                <select id="manager_id" name="manager_id" class="form-select">
                    <option value="">{{ __('dashboard.select_branch_manager') }}</option>
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
