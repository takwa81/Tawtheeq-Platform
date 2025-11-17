@extends('dashboard.layouts.app')

@section('content')
<div class="content-header d-flex justify-content-between align-items-center mb-3">
    <h2 class="content-title card-title">{{ __('dashboard.subscription_package_details') }}</h2>
    <a href="javascript:void(0)" onclick="history.back()" class="btn btn-md rounded font-sm" title="{{ __('dashboard.back') }}">
        <i class="material-icons md-arrow_back"></i>
    </a>
</div>

<div class="row">
    <!-- Package Info Card -->
    <div class="col-md-6">
        <div class="card mb-3 shadow-sm">
            <div class="card-header bg-info text-white">
                {{ __('dashboard.package_info') }}
            </div>
            <div class="card-body">
                <p><strong>{{ __('dashboard.subscription_package') }}:</strong> {{ $package->name ?? '-' }}</p>
                <p><strong>{{ __('dashboard.branch_limit') }}:</strong> {{ $package->branches_limit ?? '-' }}</p>
                <p><strong>{{ __('dashboard.price') }}:</strong> {{ $package->price ?? '-' }} {{ __('dashboard.currency') }}</p>
                <p><strong>{{ __('dashboard.duration_days') }}:</strong> {{ $package->duration_days ?? '-' }}</p>

                <p>
                    <strong>{{ __('dashboard.total_subscriptions') }}:</strong>
                    <a href="{{ route('dashboard.subscriptions.index', ['package_id' => $package->id]) }}" class="btn btn-md rounded font-sm">
                        {{ $package->subscriptions_count }} {{ __('dashboard.view') }}  <i class="material-icons md-remove_red_eye"></i>
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Features Card -->
    @if(!empty($package->features))
    <div class="col-md-6">
        <div class="card mb-3 shadow-sm">
            <div class="card-header bg-info text-white">
                {{ __('dashboard.package_features') }}
            </div>
            <div class="card-body">
                <ul>
                    @foreach($package->features as $feature)
                        <li>{{ $feature }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
