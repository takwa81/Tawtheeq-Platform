@extends('dashboard.layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="content-header">
                <h2 class="content-title">{{ __('dashboard.change_password') }}</h2>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>{{ __('dashboard.change_password') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" id="changePasswordForm" action="{{ route('dashboard.reset-password') }}">
                        @csrf

                        <div class="row">
                            <div class="mb-3 col-md-6">
                                <label for="password" class="form-label">
                                    {{ __('dashboard.new_password') }} <span class="text-danger">*</span>
                                </label>

                                <div class="input-group">
                                    <input type="text" class="form-control password-input" name="password">

                                </div>


                                <div class="text-danger" id="passwordError"></div>
                            </div>

                            <x-form.input id="password_confirmation" name="password_confirmation"
                                label="{{ __('dashboard.confirm_password') }}" type="password" required="true"
                                errorId="passwordConfirmationError" />

                            <div class="col-lg-12 text-end">
                                <button id="submitPasswordBtn" class="btn btn-md rounded font-sm hover-up">
                                    {{ __('dashboard.save_changes') }}
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
