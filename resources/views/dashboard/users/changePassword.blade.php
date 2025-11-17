
<x-modals.form modalId="changePasswordModal" formId="changePasswordForm" :action="route('dashboard.users.change_password')"
    title="{{ __('dashboard.change_password') }}" size="modal-lg">

    <input type="hidden" id="cp_user_id" name="user_id" />

    <div class="row">
        <div class="col-md-6 mb-3">
            <label for="password" class="form-label">"{{ __('dashboard.new_password') }}" <span
                    class="text-danger">*</span></label>
            <div class="input-group">
                <input type="text" class="form-control password-input" name="password">
                <button type="button" class="btn btn-md bg-info rounded font-sm generate-password-btn"
                    title="{{ __('dashboard.generate_strong_password') }}">
                    <i class="material-icons md-vpn_key"></i>
                </button>
            </div>
            <div class="mt-1">
                <span class="password-strength-badge badge"></span>
            </div>
            <div class="text-danger" id="passwordError"></div>
        </div>

        <x-form.input id="password_confirmation" name="password_confirmation"
            label="{{ __('dashboard.confirm_password') }}" type="text" required="true"
            class="password-confirmation-input" errorId="passwordConfirmationError" />

    </div>
</x-modals.form>
