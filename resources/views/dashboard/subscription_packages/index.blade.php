@extends('dashboard.layouts.app')

@section('content')
    <x-dashboard.page-header :title="__('dashboard.subscription_packages')" addModalId="subscriptionModal" />
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
                            </ul>


                            @if (!empty($package->features))
                                <h6 class="text-secondary">{{ __('dashboard.features') }}:</h6>
                                <ul class="small ps-3">
                                    @foreach ($package->features as $feature)
                                        <li>{{ $feature }}</li>
                                    @endforeach
                                </ul>
                            @endif
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
    <script src="{{ asset('admin/dashboard/pages/delete.js') }}"></script>
    <script src="{{ asset('admin/dashboard/pages/subscription_package.js') }}"></script>
@endsection
