<x-modals.form
    modalId="changePasswordModal"
    formId="changePasswordForm"
    :action="route('dashboard.users.change_password')"
    title="{{ __('dashboard.change_password') }}"
    size="modal-md">

    <input type="hidden" id="cp_user_id" name="user_id" />

    <div class="row">
        <x-form.input
            id="password"
            name="password"
            label="{{ __('dashboard.new_password') }}"
            type="password"
            required="true"
            errorId="passwordError"
            :col="6" />

        <x-form.input
            id="password_confirmation"
            name="password_confirmation"
            label="{{ __('dashboard.confirm_password') }}"
            type="password"
            required="true"
            errorId="password_confirmationError"
            :col="6" />
    </div>
</x-modals.form>
