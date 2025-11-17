@extends('dashboard.layouts.app')

@section('content')
<x-dashboard.page-header :title="__('dashboard.subscriptions')" />

<!-- 🔍 Search & Filters -->
<x-dashboard.search-sort :route="route('dashboard.subscriptions.index')">
    <div class="col-md-3 mb-2">
        <input type="text" name="user_id" value="{{ request('user_id') }}"
            placeholder="{{ __('dashboard.search_by_user_id') }}" class="form-control bg-white">
    </div>

    <div class="col-md-3 mb-2">
        <select name="status" class="form-select bg-white">
            <option value="">{{ __('dashboard.all_statuses') }}</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>
                {{ __('dashboard.active') }}
            </option>
            <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>
                {{ __('dashboard.expired') }}
            </option>
        </select>
    </div>

    <div class="col-md-3 mb-2">
        <select name="package_id" class="form-select bg-white">
            <option value="">{{ __('dashboard.all_packages') }}</option>
            @foreach ($packages as $package)
                <option value="{{ $package->id }}" {{ request('package_id') == $package->id ? 'selected' : '' }}>
                    {{ $package->name }} - {{ $package->price }} {{ __('dashboard.currency') }}
                </option>
            @endforeach
        </select>
    </div>
</x-dashboard.search-sort>


<div class="row g-3 mt-2 justify-content-center">
    @forelse($subscriptions as $sub)
        <div class="col-md-4">
            <div class="card h-100 shadow-sm border">
                <div class="card-header bg-main text-white">
                    <a href="{{ route('dashboard.branch_managers.show', $sub->user->id ?? '#') }}"
                       class="text-white text-decoration-none">
                        {{ $sub->user->full_name ?? '-' }}
                    </a>
                </div>

                <div class="card-body">
                    <p><strong>{{ __('dashboard.subscription_package') }}:</strong> {{ $sub->package->name ?? '-' }}</p>
                    <p><strong>{{ __('dashboard.branch_limit') }}:</strong> {{ $sub->package->branches_limit ?? '-' }}</p>
                    <p><strong>{{ __('dashboard.branches_count') }}:</strong> {{ $sub->user->branchManager?->branches_count ?? 0 }}</p>
                    <p><strong>{{ __('dashboard.start_date') }}:</strong> {{ $sub->start_date?->format('Y-m-d') ?? '-' }}</p>
                    <p><strong>{{ __('dashboard.expired_at') }}:</strong> {{ $sub->end_date?->format('Y-m-d') ?? '-' }}</p>
                    <p>
                        <strong>{{ __('dashboard.remaining_days') }}:</strong>
                        @if ($sub->remaining_days !== null)
                            <span class="badge {{ $sub->remaining_days > 0 ? 'bg-success' : 'bg-danger' }}">
                                {{ $sub->remaining_days }} {{ __('dashboard.days') }}
                            </span>
                        @else
                            <span class="badge bg-secondary">-</span>
                        @endif
                    </p>
                </div>

                <div class="card-footer text-end">
                    <a href="{{ route('dashboard.subscriptions.show', $sub->id) }}" class="btn btn-md rounded font-sm">
                        <i class="material-icons md-remove_red_eye"></i> {{ __('dashboard.view_details') }}
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center">
            <x-no-data-found />
        </div>
    @endforelse
</div>

<x-dashboard.pagination :paginator="$subscriptions" />
@endsection
