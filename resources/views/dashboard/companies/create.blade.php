<x-modals.form modalId="companyModal" formId="companyForm" :action="route('dashboard.companies.store')" :title="__('dashboard.add_new_company')" size="modal-lg">

    <input type="hidden" id="record_id" name="id" />

    <div class="row">
        <x-form.input id="name_ar" name="name_ar" :label="__('dashboard.name_ar')" required="true" errorId="name_arError" />

        <x-form.input id="name_en" name="name_en" :label="__('dashboard.name_en')" required="true" errorId="name_enError" />

        <x-form.file id="logo" name="logo" :label="__('dashboard.company_logo')" errorId="logoError" />

    </div>

</x-modals.form>
