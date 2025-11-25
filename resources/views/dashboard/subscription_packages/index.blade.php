@extends('dashboard.layouts.app')

@section('content')
    <x-dashboard.page-header :title="__('dashboard.subscription_packages')" addModalId="subscriptionModal" />

    <div class="row text-center mb-4">
        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h6 class="text-muted">{{ __('dashboard.total_subscriptions') }}</h6>
                <h3 class="fw-bold">{{ $stats['total_subscriptions'] }}</h3>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h6 class="text-muted">{{ __('dashboard.best_selling_package') }}</h6>
                <h5 class="fw-bold">
                    {{ app()->getLocale() == 'ar' ? $stats['top_package']->name_ar : $stats['top_package']->name_en }}
                </h5>
                <small>({{ $stats['top_package']->subscriptions_count }} {{ __('dashboard.subscriptions') }})</small>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card p-3 shadow-sm">
                <h6 class="text-muted">{{ __('dashboard.least_selling_package') }}</h6>
                <h5 class="fw-bold">
                    {{ app()->getLocale() == 'ar' ? $stats['low_package']->name_ar : $stats['low_package']->name_en }}
                </h5>
                <small>({{ $stats['low_package']->subscriptions_count }} {{ __('dashboard.subscriptions') }})</small>
            </div>
        </div>
    </div>
    {{-- <div class="row my-4">
        <div class="col-lg-6">
            <div class="card shadow-sm p-3">
                <h6 class="fw-bold mb-3">{{ __('dashboard.total_subscriptions') }}</h6>
                <canvas id="subscriptionPieChart"></canvas>
            </div>
        </div>
    </div> --}}


    <div class="my-2">
        <x-dashboard.search-sort :route="route('dashboard.subscription_packages.index')" :showName="true">

        </x-dashboard.search-sort>
    </div>



    <div class="row g-3" id="cardsContainer">
        @forelse ($packages as $package)
            <div class="col-lg-4 col-md-6">
                <div class="card shadow-sm border-0 rounded-3 h-100">
                    <div class="card-body d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold text-primary mb-2">
                                {{ app()->getLocale() === 'ar' ? $package->name_ar : $package->name_en }}
                            </h5>

                            @if ($package->description)
                                <p class="text-muted small mb-3">{{ $package->description }}</p>
                            @endif

                            <ul class="list-unstyled mb-3">
                                <li><strong>{{ __('dashboard.branches_limit') }}:</strong> {{ $package->branches_limit }}
                                </li>
                                <li><strong>{{ __('dashboard.duration') }}:</strong> {{ $package->duration_days }}
                                    {{ __('dashboard.days') }}</li>
                                <li><strong>{{ __('dashboard.price') }}:</strong> {{ number_format($package->price, 2) }}
                                    {{ __('dashboard.currency') }}</li>
                                <li><strong>{{ __('dashboard.total_subscriptions') }}:</strong>{{ $package->subscriptions_count }}
                                </li>
                            </ul>


                            {{-- @if (!empty($package->features))
                                <h6 class="text-secondary">{{ __('dashboard.features') }}:</h6>
                                <ul class="small ps-3">
                                    @foreach ($package->features as $feature)
                                        <li>{{ $feature }}</li>
                                    @endforeach
                                </ul>
                            @endif --}}
                        </div>

                        <div class="mt-3 text-end">
                            <a href="javascript:void(0)" class="btn btn-md rounded font-sm edit-data"
                                data-id="{{ $package->id }}" data-name_en="{{ $package->name_en }}"
                                data-name_ar="{{ $package->name_ar }}" data-description="{{ $package->description }}"
                                data-price="{{ $package->price }}" data-branches_limit="{{ $package->branches_limit }}"
                                data-duration_days="{{ $package->duration_days }}"
                                data-features='@json($package->features)' title="{{ __('dashboard.edit_info') }}">
                                <i class="material-icons md-edit"></i>
                            </a>
                            <a href="{{ route('dashboard.subscription_packages.show', $package->id) }}"
                                class="btn btn-md bg-secondary rounded font-sm">
                                <i class="material-icons md-remove_red_eye"></i>
                            </a>
                            <form class="d-inline delete-form"
                                action="{{ route('dashboard.subscription_packages.destroy', $package->id) }}"
                                method="POST" data-id="{{ $package->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-md bg-danger rounded font-sm delete-button"
                                    title="{{ __('dashboard.delete_plan') }}">
                                    <i class="material-icons md-delete"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center py-5">
                <x-no-data-found />
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        <x-dashboard.pagination :paginator="$packages" />
    </div>

    @include('dashboard.subscription_packages.create')
@endsection

@section('scripts')
    <script>
        window.translations = {
            enterFeature: "{{ __('dashboard.enter_feature') }}",
            addFeature: "{{ __('dashboard.add_feature') }}",
            editPackage: "{{ __('dashboard.edit_package') }}",
            createPackage: "{{ __('dashboard.create_package') }}",
            saving: "{{ __('dashboard.saving') }}",
            updating: "{{ __('dashboard.updating') }}",
            save: "{{ __('dashboard.save') }}",
            update: "{{ __('dashboard.update') }}",
            successCreate: "{{ __('dashboard.success_create') }}",
            successUpdate: "{{ __('dashboard.success_update') }}",
            deletePackage: "{{ __('dashboard.delete_package') }}",
            errorUnexpected: "{{ __('dashboard.error_unexpected') }}",
            featuresLabel: "{{ __('dashboard.features') }}",
            branches_count: "{{ __('dashboard.branches_count') }}",
            duration: "{{ __('dashboard.duration') }}",
            price: "{{ __('dashboard.price') }}",
            edit_package: "{{ __('dashboard.edit_package') }}",
            delete_package: "{{ __('dashboard.delete_package') }}",
            day: "{{ __('dashboard.day') }}"
        };
    </script>

    <script src="{{ asset('admin/dashboard/pages/delete.js') }}"></script>
    <script src="{{ asset('admin/dashboard/pages/subscription_package.js') }}"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/chart.js"></script> --}}
    {{--
    <script>
        const pieLabels = {!! json_encode(app()->getLocale() === 'ar' ? $chartData->pluck('name_ar') : $chartData->pluck('name_en')) !!};

        const pieData = {!! json_encode($chartData->pluck('subscriptions_count')) !!};

        const pieCtx = document.getElementById('subscriptionPieChart');

        new Chart(pieCtx, {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    data: pieData,
                    backgroundColor: [
                        '#4e73df', '#1cc88a', '#36b9cc', '#f6c23e',
                        '#e74a3b', '#858796', '#20c9a6', '#6f42c1'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'bottom',
                    }
                }
            }
        });
    </script> --}}
@endsection
