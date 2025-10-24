@extends('dashboard.layouts.app')

@section('content')
    <x-dashboard.page-header :title="__('dashboard.companies')" addModalId="companyModal" />

    <div class="my-2">
        <x-dashboard.search-sort :route="route('dashboard.companies.index')" />
    </div>

    <div class="card mb-4">
        <div class="card-body p-0">
            <x-dashboard.table :headers="[
                '#',
                __('dashboard.company_logo'),
                __('dashboard.name_ar'),
                __('dashboard.name_en'),
                __('dashboard.options'),
            ]">
                @forelse($companies as $company)
                    <tr id="row-{{ $company->id }}">
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <img src="{{ $company->logo_url }}" alt="{{ $company->name_ar }}" class="rounded-circle"
                                width="40" height="40">
                        </td>
                        <td>{{ $company->name_ar }}</td>
                        <td>{{ $company->name_en }}</td>
                        <td>
                            <x-dashboard.actions :id="$company->id" :editData="[
                                'name_ar' => $company->name_ar,
                                'name_en' => $company->name_en,
                                'logo' => $company->logo_url,
                            ]" :deleteRoute="route('dashboard.companies.destroy', $company->id)" :showRoute="route('dashboard.companies.show', $company->id)" />
                        </td>
                    </tr>
                @empty
                    <tr id="noDataRow">
                        <td colspan="5" class="text-center">
                            <x-no-data-found />
                        </td>
                    </tr>
                @endforelse
            </x-dashboard.table>
        </div>
    </div>

    <x-dashboard.pagination :paginator="$companies" />

    @include('dashboard.companies.create')
@endsection

@section('scripts')
    <script>
        window.dashboardLang = {
            edit_company: "{{ __('dashboard.edit_company') }}",
            edit: "{{ __('dashboard.edit') }}",
            updating: "{{ __('dashboard.updating') }}",
            saving: "{{ __('dashboard.saving') }}",
            updated_successfully: "{{ __('dashboard.updated_successfully') }}",
            created_successfully: "{{ __('dashboard.created_successfully') }}",
            unexpected_error: "{{ __('dashboard.unexpected_error') }}",
            add_new_company: "{{ __('dashboard.add_new_company') }}",
            save: "{{ __('dashboard.save') }}"
        };
    </script>

    <script src="{{ asset('admin/dashboard/pages/companies.js') }}"></script>
    <script src="{{ asset('admin/dashboard/pages/delete.js') }}"></script>
@endsection
