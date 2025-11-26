@extends('dashboard.layouts.app')

@section('styles')
@endsection

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="content-header">
                <h2 class="content-title">{{ __('dashboard.account_information') }}</h2>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4>{{ __('dashboard.edit_account_information') }}</h4>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('dashboard.account.update') }}" id="employeeForm"
                        autocomplete="off">
                        @csrf
                        <div class="row">
                            <x-form.input id="full_name" name="full_name"
                                :label="__('dashboard.full_name')" required="true"
                                value="{{ auth()->user()->full_name }}" errorId="full_nameError" />

                            <x-form.input id="phone" name="phone"
                                :label="__('dashboard.phone_number')" required="true"
                                value="{{ auth()->user()->phone }}" errorId="phoneError" />
                        </div>

                        <button type="submit" class="btn btn-primary col-md-3 mt-3">{{ __('dashboard.update') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
