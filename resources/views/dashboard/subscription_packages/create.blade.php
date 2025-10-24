<x-modals.form modalId="subscriptionModal" formId="subscriptionForm"
    :action="route('dashboard.subscription_packages.store')" title="إضافة باقة جديدة">

    <div class="row">
        {{-- <x-form.input name="name_ar" label="الاسم (عربي)" required="true" />
        <x-form.input name="name_en" label="الاسم (إنجليزي)" required="true" />
        <x-form.input name="price" label="السعر" type="number" step="0.01" required="true" />
        <x-form.input name="branches_limit" label="عدد الفروع المسموح" type="number" required="true" />
        <x-form.input name="duration_days" label="عدد الأيام" type="number" required="true" />
        <x-form.textarea name="description" label="الوصف" />
        <x-form.textarea name="features" label="المميزات (افصلها بفاصلة ,)" /> --}}
    </div>
</x-modals.form>
