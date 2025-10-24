@extends('dashboard.layouts.app')

@section('content')
    <div class="content-header d-flex justify-content-between align-items-center mb-3">
        <div>
            <h2 class="content-title card-title">تفاصيل البلد {{ $country->name_ar }} / {{ $country->name_en }}
            </h2>
            <p class="card-title">عدد المحافظات: <strong>{{ $country->governorates_count }}</strong></p>
        </div>
        <div>
            <a href="javascript:void(0)" onclick="history.back()" class="btn btn-md rounded font-sm">
                <i class="material-icons md-arrow_back"></i>
            </a>
        </div>

    </div>

    <div class="my-2 d-flex justify-content-end">
        <a href="javascript:void(0)" class="btn btn-md rounded font-sm" data-bs-toggle="modal"
            data-bs-target="#governorateModal">
            <i class="material-icons md-plus"></i> إضافة محافظة جديدة
        </a>
    </div>

    <div class="my-2">
        <x-dashboard.search-sort :route="route('dashboard.countries.show', $country->id)" />
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-body p-0">
                    <x-dashboard.table :headers="['#', 'البلد', 'الاسم بالعربي', 'الاسم بالانكليزي', 'عدد المناطق', 'خيارات']">
                        @forelse($governorats as $governorate)
                            <tr id="row-{{ $governorate->id }}">
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $governorate->country->name_ar }}</td>
                                <td>{{ $governorate->name_ar }}</td>
                                <td>{{ $governorate->name_en }}</td>
                                <td>{{ $governorate->zones_count }}</td>

                                <td>
                                    <x-dashboard.actions :id="$governorate->id" :editData="[
                                        'name_ar' => $governorate->name_ar,
                                        'name_en' => $governorate->name_en,
                                    ]" :deleteRoute="route('dashboard.governorates.destroy', $governorate->id)"
                                        :showRoute="route('dashboard.governorates.show', $governorate->id)" />
                                </td>
                            </tr>
                        @empty
                            <tr id="noDataRow">
                                <td colspan="4" class="text-center">
                                    <x-no-data-found />
                                </td>
                            </tr>
                        @endforelse
                    </x-dashboard.table>
                </div>

            </div>
            <x-dashboard.pagination :paginator="$governorats" />
        </div>
    </div>

    @include('dashboard.governorates.create', ['country' => $country])
@endsection

@section('scripts')
    <script src="{{ asset('admin/dashboard/pages/governorates.js') }}"></script>
    <script src="{{ asset('admin/dashboard/pages/delete.js') }}"></script>
@endsection
