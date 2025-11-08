<x-modals.form modalId="subscriptionModal" formId="subscriptionForm"
:action="route('dashboard.subscription_packages.store')" :title="__('dashboard.add_new_package')" size="modal-lg">

    <div class="row">
        <x-form.input id="name_ar" name="name_ar" :label="__('dashboard.name_ar')" required="true" errorId="name_arError" />

        <x-form.input id="name_en" name="name_en" :label="__('dashboard.name_en')" required="true" errorId="name_enError" />
        <x-form.input id="branches_limit" name="branches_limit" :label="__('dashboard.branches_limit')" type="number" required="true"
            errorId="branches_limitError" />
        <x-form.input id="price" name="price" :label="__('dashboard.price')" required="true" errorId="priceError" />
        <x-form.input id="duration_days" name="duration_days" :label="__('dashboard.duration_days')" required="true" errorId="duration_daysError" :col="12" />

        <x-form.textarea id="description_ar" name="description_ar" :label="__('dashboard.description_ar')"  />
        <x-form.textarea id="description_en" name="description_en" :label="__('dashboard.description_en')" />

        <div class="col-12 mt-3">
            <label class="form-label fw-bold">{{ __('dashboard.features') }}</label>
            <div id="featuresContainer">
                <div class="input-group mb-2 feature-item">
                    <input type="text" name="features[]" class="form-control" placeholder="{{ __('dashboard.enter_feature') }}">
                    <button type="button" class="btn btn-md bg-danger rounded font-sm remove-feature">
                        <i class="material-icons md-delete"></i>
                    </button>
                </div>
            </div>
              <button type="button" class="btn btn-md rounded font-sm mt-2 mb-5" id="addFeature">
                <i class="material-icons md-add"></i> {{ __('dashboard.add_feature') }}
            </button>
            <div id="featuresError" class="text-danger small mt-1"></div>
        </div>

    </div>
</x-modals.form>
