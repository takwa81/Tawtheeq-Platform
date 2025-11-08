    @extends('dashboard.layouts.app')

    @section('styles')
        <style>
            .form-check-input.form-check-input:checked {
                background-color: #ff5087 !important;
            }

            .form-check-input {
                width: 1.3em;
                height: 1.3em;
            }

            .form-check {
                width: 60%;
            }
        </style>
    @endsection
    @section('content')
        <x-dashboard.page-header :title="__('dashboard.branch_managers')" addModalId="dataEntryModal" />

        <div class="alert alert-secondary p-3 text-light" role="alert">
            <i class="material-icons md-info me-2 fs-4 align-top"></i>
            <strong>{{ __('dashboard.notes') }}:</strong>
            <div class="row mt-2" style="font-size: 13px; line-height: 1.4;">
                <div class="col-4">{{ __('dashboard.search_by_name_or_phone') }}</div>
                <div class="col-4">{{ __('dashboard.filter_by_status') }}</div>
                <div class="col-4">
                    {{ __('dashboard.activate_or_deactivate') }}
                    <i class="material-icons md-toggle_on"></i>/<i class="material-icons md-toggle_off"></i>
                </div>
                <div class="col-4">{{ __('dashboard.show_deleted_only') }} <i class="material-icons md-check_box"></i>
                </div>
                <div class="col-4">{{ __('dashboard.restore_deleted') }} <i class="material-icons md-restore"></i></div>
                <div class="col-4">{{ __('dashboard.view_details') }} <i class="material-icons md-remove_red_eye"></i>
                </div>
            </div>
        </div>


        <!-- Search & Filters -->
        <div class="my-2">

            <x-dashboard.search-sort :route="route('dashboard.branch_managers.index')" :showName="true">

                <div class="col-lg-3 col-md-3 mt-1">
                    <input type="text" name="phone" value="{{ request()->get('phone') }}"
                        placeholder="{{ __('dashboard.search_by_phone') }}" class="form-control bg-white">
                </div>

                <div class="col-lg-3 col-md-3 mt-1">
                    <select name="status" class="form-select bg-white">
                        <option value="">{{ __('dashboard.all_statuses') }}</option>
                        <option value="active" {{ request()->get('status') === 'active' ? 'selected' : '' }}>
                            {{ __('dashboard.active') }}
                        </option>
                        <option value="inactive" {{ request()->get('status') === 'inactive' ? 'selected' : '' }}>
                            {{ __('dashboard.inactive') }}
                        </option>
                        <option value="deleted" {{ request()->get('status') === 'deleted' ? 'selected' : '' }}>
                            {{ __('dashboard.deleted') }}
                        </option>
                    </select>
                </div>

                <div class="col-lg-3 col-md-3 mt-1 d-flex align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="only_trashed" value="1" id="onlyTrashed"
                            {{ request()->get('only_trashed') ? 'checked' : '' }}>
                        <label class="form-check-label" for="onlyTrashed">
                            {{ __('dashboard.show_deleted_only') }}
                        </label>
                    </div>
                </div>

            </x-dashboard.search-sort>

        </div>

        <div class="card mb-4">
            <div class="card-body p-0">
                <x-dashboard.table :headers="[
                    '#',
                    __('dashboard.full_name'),
                    __('dashboard.phone_number'),
                    __('dashboard.branches_count'),
                    __('dashboard.status'),
                    __('dashboard.options'),
                ]">
                    @forelse($managers as $user)
                        <tr id="row-{{ $user->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->branchManager?->branches_count ?? 0 }}</td>

                            <td>{!! accountStatusBadge($user->status) !!}</td>
                            <td>
                                <div class="">
                                    @if ($user->deleted_at === null)
                                        <a href="javascript:void(0)" class="btn btn-md rounded font-sm edit-data"
                                            data-id="{{ $user->id }}" data-full_name="{{ $user->full_name }}"
                                            data-email="{{ $user->email }}" data-phone="{{ $user->phone }}"
                                            title="{{ __('dashboard.edit_info') }}">
                                            <i class="material-icons md-edit"></i>
                                        </a>

                                        <form class="d-inline delete-form"
                                            action="{{ route('dashboard.branch_managers.destroy', $user->id) }}"
                                            method="POST" data-id="{{ $user->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-md bg-danger rounded font-sm delete-button"
                                                title="{{ __('dashboard.delete_user') }}">
                                                <i class="material-icons md-delete"></i>
                                            </button>
                                        </form>
                                        <a href="javascript:void(0)"
                                            class="btn btn-md bg-info rounded font-sm change-password-btn"
                                            data-id="{{ $user->id }}" data-full_name="{{ $user->full_name }}"
                                            title="{{ __('dashboard.change_password') }}">
                                            <i class="material-icons md-lock"></i>
                                        </a>
                                        @if ($user->status === 'active')
                                            <a href="#"
                                                class="btn btn-md bg-warning rounded font-sm my-1 toggle-status"
                                                data-url="{{ route('dashboard.branch_managers.deactivate', $user->id) }}"
                                                data-status="active" title="{{ __('dashboard.deactivate') }}">
                                                <i class="material-icons md-toggle_off"></i>
                                            </a>
                                        @else
                                            <a href="#"
                                                class="btn btn-md bg-success rounded font-sm my-1 toggle-status"
                                                data-url="{{ route('dashboard.branch_managers.activate', $user->id) }}"
                                                data-status="inactive" title="{{ __('dashboard.activate') }}">
                                                <i class="material-icons md-toggle_on"></i>
                                            </a>
                                        @endif
                                    @endif

                                    @if ($user->deleted_at)
                                        <form class="d-inline restore-form"
                                            action="{{ route('dashboard.branch_managers.restore', $user->id) }}"
                                            method="POST" data-id="{{ $user->id }}">
                                            @csrf
                                            <button type="button"
                                                class="btn btn-md bg-success rounded font-sm restore-button"
                                                title="{{ __('dashboard.restore') }}">
                                                <i class="material-icons md-restore"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('dashboard.branch_managers.show', $user->id) }}"
                                        class="btn btn-md rounded font-sm bg-secondary text-white"
                                        title="{{ __('dashboard.view_details') }}">
                                        <i class="material-icons md-remove_red_eye"></i>
                                    </a>
                                </div>
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

        <x-dashboard.pagination :paginator="$managers" />

        @include('dashboard.branch_managers.create')
        @include('dashboard.users.changePassword')
    @endsection

    @section('scripts')
        <script src="{{ asset('admin/dashboard/pages/branch_manager.js') }}"></script>
        <script src="{{ asset('admin/dashboard/pages/delete.js') }}"></script>
        <script src="{{ asset('admin/dashboard/pages/restore.js') }}"></script>
        <script src="{{ asset('admin/dashboard/pages/toggle.js') }}"></script>
        <script src="{{ asset('admin/dashboard/pages/changePassword.js') }}"></script>
    @endsection
