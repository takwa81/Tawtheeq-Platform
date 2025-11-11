<x-modals.form modalId="dataEntryModal" formId="dataEntryForm" :action="route('dashboard.branch_managers.store')" :title="__('dashboard.add_branch_manager')" size="modal-lg">

    <input type="hidden" id="record_id" name="id" />

    <div class="row">
        <x-form.input id="full_name" name="full_name" :label="__('dashboard.full_name')" required="true" errorId="full_nameError"
            :col="12" />

        <x-form.input id="phone" name="phone" :label="__('dashboard.phone')" required="true" errorId="phoneError" />

        <x-form.input id="email" name="email" :label="__('dashboard.email')" errorId="emailError" />

        <x-form.input id="password" name="password" :label="__('dashboard.password')" type="password" required="true"
            errorId="passwordError" />

        <x-form.input id="password_confirmation" name="password_confirmation" :label="__('dashboard.password_confirmation')" type="password"
            required="true" errorId="passwordConfirmationError" />
    </div>

</x-modals.form>
