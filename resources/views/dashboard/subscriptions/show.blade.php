@extends('dashboard.layouts.app')

@section('content')
    <div class="content-header d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="content-title card-title">{{ __('dashboard.subscription_details') }}</h2>
        </div>
        <div>
            <a href="javascript:void(0)" onclick="history.back()" class="btn btn-md rounded font-sm"
                title="{{ __('dashboard.back') }}">
                <i class="material-icons md-arrow_back"></i>
            </a>
        </div>
    </div>
    <div class="row">
        <!-- User Info Card -->
        <div class="col-md-6">
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-main text-white">
                    {{ __('dashboard.user_info') }}
                </div>
                <div class="card-body">
                    <p><strong>{{ __('dashboard.full_name') }}:</strong>
                        <a href="{{ route('dashboard.branch_managers.show', $subscription->user->id ?? '#') }}">
                            {{ $subscription->user->full_name ?? '-' }}</a>
                    </p>
                    <p><strong>{{ __('dashboard.phone_number') }}:</strong> {{ $subscription->user->phone ?? '-' }}</p>
                    <p><strong>{{ __('dashboard.email') }}:</strong> {{ $subscription->user->email ?? '-' }}</p>
                    <p><strong>{{ __('dashboard.branches_count') }}:</strong>
                        {{ $subscription->user->branchManager?->branches_count ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- Subscription Info Card -->
        <div class="col-md-6">
            <div class="card mb-3 shadow-sm">
                <div class="card-header bg-info text-white">
                    {{ __('dashboard.subscription_info') }}
                </div>
                <div class="card-body">
                    <p><strong>{{ __('dashboard.subscription_package') }}:</strong>
                        <a href="{{ route('dashboard.subscription_packages.show', $subscription->package->id ?? '#') }}">
                            {{ $subscription->package->name ?? '-' }}
                    </p></a>
                    <p><strong>{{ __('dashboard.branch_limit') }}:</strong>
                        {{ $subscription->package->branches_limit ?? '-' }}</p>
                    <p><strong>{{ __('dashboard.price') }}:</strong> {{ $subscription->package->price ?? '-' }}
                        {{ __('dashboard.currency') }}</p>
                    <p><strong>{{ __('dashboard.duration_days') }}:</strong>
                        {{ $subscription->package->duration_days ?? '-' }}</p>
                    <p><strong>{{ __('dashboard.start_date') }}:</strong>
                        {{ $subscription->start_date?->format('Y-m-d') ?? '-' }}</p>
                    <p><strong>{{ __('dashboard.expired_at') }}:</strong>
                        {{ $subscription->end_date?->format('Y-m-d') ?? '-' }}</p>
                    <p>
                        <strong>{{ __('dashboard.remaining_days') }}:</strong>
                        @if ($subscription->remaining_days !== null)
                            <span class="badge {{ $subscription->remaining_days > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $subscription->remaining_days }} {{ __('dashboard.days') }}
                            </span>
                        @else
                            <span class="badge bg-secondary">-</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Features / Description Card -->
    @if (!empty($subscription->package->features))
        <div class="card mb-3 shadow-sm">
            <div class="card-header bg-info text-white">
                {{ __('dashboard.package_features') }}
            </div>
            <div class="card-body">
                <ul>
                    @foreach ($subscription->package->features as $feature)
                        <li>{{ $feature }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
@endsection
