@extends('dashboard.layouts.app')

@section('content')
    <div class="content-header d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="content-title card-title">{{ __('dashboard.order_details') }}</h2>
        </div>
        <div>
            <a href="javascript:void(0)" onclick="history.back()" class="btn btn-md rounded font-sm"
               title="{{ __('dashboard.back') }}">
                <i class="material-icons md-arrow_back"></i>
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm rounded-3 mb-3">
                <div class="card-header bg-main text-light">
                    <h5 class="mb-0 text-light">{{ __('dashboard.order_number') }} #{{ $order->order_number ?? '-' }}</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">

                        <div class="col-12 col-md-6">
                            <p class="mb-1"><strong>{{ __('dashboard.branch') }}:</strong>
                                <a href="{{ route('dashboard.branches.show', $order->branch->user->id) }}">
                                    {{ $order->branch->user->full_name ?? '-' }}
                                </a>
                            </p>
                            <p class="mb-1"><strong>{{ __('dashboard.company') }}:</strong> {{ $order->company->name_ar ?? '-' }}</p>
                            <p class="mb-1"><strong>{{ __('dashboard.amount') }}:</strong> {{ number_format($order->total_order, 2) }} ر.س</p>
                        </div>

                        <div class="col-12 col-md-6">
                            <p class="mb-1"><strong>{{ __('dashboard.date') }}:</strong> {{ $order->date }}</p>
                            <p class="mb-1"><strong>{{ __('dashboard.time') }}:</strong> {{ $order->time }}</p>
                            <p class="mb-1">
                                <strong>{{ __('dashboard.status') }}:</strong>
                                <span class="badge bg-{{ $order->status === 'completed' ? 'success' : ($order->status === 'issue_reported' ? 'danger' : 'secondary') }}">
                                    {{ __('dashboard.' . $order->status) }}
                                </span>
                            </p>
                        </div>

                        <div class="col-12">
                            <p class="mb-1"><strong>{{ __('dashboard.driver_name') }}:</strong> {{ $order->driver_name ?? '-' }}</p>
                            <p class="mb-1"><strong>{{ __('dashboard.customer_name') }}:</strong> {{ $order->customer_name ?? '-' }}</p>
                            <p class="mb-1"><strong>{{ __('dashboard.customer_phone') }}:</strong> {{ $order->customer_phone ?? '-' }}</p>
                        </div>

                        @if ($order->order_image)
                            <p>{{ __('dashboard.order_image') }}:</p>
                            <div class="col-12 text-center">
                                <img src="{{ $order->order_image_url }}" class="img-fluid rounded" style="max-height: 250px;" alt="{{ __('dashboard.order_image') }}">
                            </div>
                        @endif

                        <div class="col-12">
                            <p class="mb-1"><strong>{{ __('dashboard.notes') }}:</strong></p>
                            <div class="p-2 border rounded bg-light">{{ $order->notes ?? '-' }}</div>
                        </div>

                        <div class="col-12">
                            <p class="text-muted mb-0">
                                <small>{{ __('dashboard.created_at') }}: {{ $order->created_at->format('d-m-Y H:i') }} ({{ $order->created_at->diffForHumans() }})</small>
                            </p>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
