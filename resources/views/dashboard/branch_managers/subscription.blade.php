<x-modals.form modalId="subscriptionModal" formId="subscriptionForm" :action="route('dashboard.subscriptions.store')" :title="__('dashboard.add_subscription')" size="modal-lg">

    <input type="hidden" name="manager_id" id="managerId">
    <input type="hidden" name="package_id" id="selectedPackage">

    <div class="row">

        <label class="mb-2 fw-bold">{{ __('dashboard.choose_package') }}</label>

        <div class="row g-3">
            @foreach ($packages as $package)
                <div class="col-md-4">
                    <div class="package-card p-3 rounded border text-center selectable-package"
                        data-id="{{ $package->id }}" data-price="{{ $package->price }}"
                        data-duration="{{ $package->duration_days }}" data-limit="{{ $package->branches_limit }}"
                        data-name="{{ $package->name }}" style="cursor:pointer; transition:.2s">
                        <h5 class="fw-bold">{{ $package->name }}</h5>
                        <p class="text-muted m-0">{{ $package->price }} {{ __('dashboard.currency') }}</p>
                    </div>
                </div>
            @endforeach
        </div>

        <div id="dateSection" class="row mt-3 d-none">

            <!-- Start Date -->
            <div class="col-md-6">
                <label class="form-label">{{ __('dashboard.start_date') }}</label>
                <input type="text" id="start_date_display" class="form-control" readonly>
                <input type="hidden" name="start_date" id="start_date">
            </div>

            <!-- End Date -->
            <div class="col-md-6">
                <label class="form-label">{{ __('dashboard.end_date') }}</label>
                <input type="text" id="end_date_display" class="form-control" readonly>
                <input type="hidden" name="end_date" id="end_date">
            </div>

        </div>

        <!-- Package Info -->
        <div class="col-12 mt-3 d-none" id="packageInfo">
            <div class="alert alert-info">
                <h5 class="fw-bold" id="pName"></h5>
                <p class="m-0">{{ __('dashboard.price') }}: <span id="pPrice"></span></p>
                <p class="m-0">{{ __('dashboard.duration_days') }}: <span id="pDuration"></span></p>
                <p class="m-0">{{ __('dashboard.branches_limit') }}: <span id="pLimit"></span></p>
            </div>
        </div>

    </div>

</x-modals.form>
