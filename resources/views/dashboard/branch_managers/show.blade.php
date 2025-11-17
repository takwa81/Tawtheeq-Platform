@extends('dashboard.layouts.app')

@section('content')

    <div class="content-header d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="content-title card-title">{{ __('dashboard.branch_manager_details') }} ({{ $user->full_name }})</h2>
        </div>
        <div>
            <div class="dropdown">
                <button class="btn btn-md bg-secondary text-white dropdown-toggle px-4" type="button"
                    id="dropdownMenuButton-{{ $user->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                    خيارات
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton-{{ $user->id }}">

                    {{-- Edit --}}
                    @if ($user->deleted_at === null)
                        {{-- Change Password --}}
                        <li>
                            <a class="dropdown-item change-password-btn" href="javascript:void(0)"
                                data-id="{{ $user->id }}" data-full_name="{{ $user->full_name }}">
                                <i class="material-icons md-lock me-1"></i>  {{ __('dashboard.change_password') }}
                            </a>
                        </li>

                        {{-- Activate / Deactivate --}}
                        @if ($user->status === 'active')
                            <li id="actionState">
                                <a class="dropdown-item toggle-status"
                                    data-url="{{ route('dashboard.branch_managers.deactivate', $user->id) }}"
                                    data-status="active" title="{{ __('dashboard.deactivate') }}">
                                    <i class="material-icons md-toggle_off me-1"></i> {{ __('dashboard.deactivate') }}
                                </a>
                            </li>
                        @else
                            <li id="actionState">
                                <a class="dropdown-item toggle-status" href="#"
                                    data-url="{{ route('dashboard.branch_managers.activate', $user->id) }}"
                                    data-status="inactive" title="{{ __('dashboard.activate') }}">
                                    <i class="material-icons md-toggle_on me-1"></i> {{ __('dashboard.activate') }}
                                </a>
                            </li>
                        @endif
                    @endif


                </ul>
            </div>
            <a href="javascript:void(0)" onclick="history.back()" class="btn btn-md rounded font-sm">
                <i class="material-icons md-arrow_back"></i>
            </a>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-header bg-main text-light d-flex justify-content-between align-items-center">
            <h5 class="mb-0 text-light">{{ __('dashboard.branch_manager_details') }}</h5>
        </div>

        <div class="card-body">
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <strong>{{ __('dashboard.full_name') }}:</strong> {{ $user->full_name }}
                </div>
                <div class="col-md-6">
                    <strong>{{ __('dashboard.phone') }}:</strong> {{ $user->phone }}
                </div>
                <div class="col-md-6">
                    <strong>{{ __('dashboard.email') }}:</strong> {{ $user->email ?? '-' }}
                </div>
                <div class="col-md-6">
                    <strong>{{ __('dashboard.status') }}:</strong>
                    <span id="statusBadge">
                        {!! accountStatusBadge($user->status) !!}
                    </span>
                </div>
            </div>

            {{-- الفروع المرتبطة --}}
            <div class="col-12">
                <h6>{{ __('dashboard.associated_branches') }}:</h6>

                @if ($user->branchManager && $user->branchManager->branches->count())
                    <div class="row g-3">
                        @foreach ($user->branchManager->branches as $branch)
                            <div class="col-md-4 col-sm-6">
                                <div class="card shadow-sm rounded-3 h-100">
                                    <div class="card-body d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $branch->user->full_name ?? '-' }}</strong><br>
                                            <small class="text-muted">{{ $branch->user->phone ?? '-' }}</small>
                                        </div>
                                        <div>
                                            <a href="{{ route('dashboard.branches.show', $branch->user) }}"
                                                class="btn btn-md rounded font-sm bg-secondary text-white"
                                                title="{{ __('dashboard.view_branch') }}">
                                                <i class="material-icons md-remove_red_eye"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p>{{ __('dashboard.no_associated_branches') }}</p>
                @endif
            </div>
        </div>
    </div>
    @include('dashboard.users.changePassword')

@endsection
@section('scripts')
    <script src="{{ asset('admin/dashboard/pages/toggle.js') }}"></script>
    <script src="{{ asset('admin/dashboard/pages/changePassword.js') }}"></script>
    <script src="{{ asset('admin/dashboard/pages/passwordCheck.js') }}"></script>
@endsection
