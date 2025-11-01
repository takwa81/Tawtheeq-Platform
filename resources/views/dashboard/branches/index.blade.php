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
        <x-dashboard.page-header :title="__('dashboard.branches')" addModalId="dataEntryModal" />

        <div class="alert alert-secondary p-3 text-light" role="alert">
            <i class="material-icons md-info me-2 fs-4 align-top"></i>
            <strong>ملاحظات:</strong>
            <div class="row mt-2" style="font-size: 13px; line-height: 1.4;">
                <div class="col-4">ابحث حسب الاسم / رقم الهاتف</div>
                <div class="col-4">فلتر حسب الحالة</div>
                <div class="col-4">التفعيل / إلغاء التفعيل <i class="material-icons md-toggle_on"></i>/<i
                        class="material-icons md-toggle_off"></i></div>
                <div class="col-4">عرض المحذوفين فقط <i class="material-icons md-check_box"></i></div>
                <div class="col-4">استرجاع المحذوفات <i class="material-icons md-restore"></i></div>
                <div class="col-4">عرض التفاصيل <i class="material-icons md-remove_red_eye"></i></div>
            </div>
        </div>


        <!-- Search & Filters -->
        <div class="my-2">
            <x-dashboard.search-sort :route="route('dashboard.branches.index')" :showName="true">
                <div class="col-lg-3 col-md-3 mt-1">
                    <input type="text" name="phone" value="{{ request()->get('phone') }}"
                        placeholder="ابحث برقم الهاتف" class="form-control bg-white">
                </div>
                @if (auth()->user()->role === 'super_admin')
                    <div class="col-lg-3 col-md-3 mt-1">
                        <select id="manager_id" name="manager_id" class="form-select bg-white">
                            <option value="">اختر مدير الفرع</option>
                            @foreach ($branchManagers as $manager)
                                <option value="{{ $manager->id }}"
                                    {{ request()->get('manager_id') === $manager->id ? 'selected' : '' }}>
                                    {{ $manager->user->full_name }}</option>
                            @endforeach
                        </select>
                        <div class="text-danger" id="manager_idError"></div>
                    </div>
                @endif

                <div class="col-lg-3 col-md-3 mt-1">
                    <select name="status" class="form-select bg-white">
                        <option value="">كل الحالات</option>
                        <option value="active" {{ request()->get('status') === 'active' ? 'selected' : '' }}>نشط
                        </option>
                        <option value="inactive" {{ request()->get('status') === 'inactive' ? 'selected' : '' }}>غير
                            نشط
                        </option>
                        <option value="deleted" {{ request()->get('status') === 'deleted' ? 'selected' : '' }}>محذوف
                        </option>
                    </select>
                </div>
                <div class="col-lg-3 col-md-3 mt-1 d-flex align-items-center">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="only_trashed" value="1" id="onlyTrashed"
                            {{ request()->get('only_trashed') ? 'checked' : '' }}>
                        <label class="form-check-label" for="onlyTrashed">
                            عرض المحذوفين فقط
                        </label>
                    </div>
                </div>
            </x-dashboard.search-sort>
        </div>

        <div class="card mb-4">
            <div class="card-body p-0">
                <x-dashboard.table :headers="['#', 'الاسم الكامل', 'رقم الهاتف', 'مدير الفرع', 'الحالة', 'خيارات']">
                    @forelse($branches as $user)
                        <tr id="row-{{ $user->id }}">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $user->full_name }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->branch->manager?->user->full_name }}</td>
                            <td>{!! accountStatusBadge($user->status) !!}</td>
                            <td>
                                <div class="">
                                    @if ($user->deleted_at === null)
                                        <a href="javascript:void(0)" class="btn btn-md rounded font-sm edit-data"
                                            data-id="{{ $user->id }}" data-full_name="{{ $user->full_name }}"
                                            data-manager_id="{{ $user->branch->manager->user->id }}"
                                            data-phone="{{ $user->phone }}" title="تعديل المعلومات">
                                            <i class="material-icons md-edit"></i>
                                        </a>

                                        <form class="d-inline delete-form"
                                            action="{{ route('dashboard.branches.destroy', $user->id) }}" method="POST"
                                            data-id="{{ $user->id }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-md bg-danger rounded font-sm delete-button"
                                                title="حذف المستخدم">
                                                <i class="material-icons md-delete"></i>
                                            </button>
                                        </form>
                                        <a href="javascript:void(0)"
                                            class="btn btn-md bg-info rounded font-sm change-password-btn"
                                            data-id="{{ $user->id }}" data-full_name="{{ $user->full_name }}"
                                            title="تغيير كلمة المرور">
                                            <i class="material-icons md-lock"></i>
                                        </a>
                                        @if ($user->status === 'active')
                                            <a href="#"
                                                class="btn btn-md bg-warning rounded font-sm my-1 toggle-status"
                                                data-url="{{ route('dashboard.branches.deactivate', $user->id) }}"
                                                data-status="active" title="إلغاء التفعيل">
                                                <i class="material-icons md-toggle_off"></i>
                                            </a>
                                        @else
                                            <a href="#"
                                                class="btn btn-md bg-success rounded font-sm my-1 toggle-status"
                                                data-url="{{ route('dashboard.branches.activate', $user->id) }}"
                                                data-status="inactive" title="تفعيل">
                                                <i class="material-icons md-toggle_on"></i>
                                            </a>
                                        @endif
                                    @endif

                                    @if ($user->deleted_at)
                                        <form class="d-inline restore-form"
                                            action="{{ route('dashboard.branches.restore', $user->id) }}" method="POST"
                                            data-id="{{ $user->id }}">
                                            @csrf
                                            <button type="button"
                                                class="btn btn-md bg-success rounded font-sm restore-button"
                                                title="استرجاع">
                                                <i class="material-icons md-restore"></i>
                                            </button>
                                        </form>
                                    @endif
                                    <a href="{{ route('dashboard.branches.show', $user->id) }}"
                                        class="btn btn-md rounded font-sm bg-secondary text-white" title="عرض التفاصيل">
                                        <i class="material-icons md-remove_red_eye"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="noDataRow">
                            <td colspan="10" class="text-center">
                                <x-no-data-found />
                            </td>
                        </tr>
                    @endforelse
                </x-dashboard.table>
            </div>
        </div>

        <x-dashboard.pagination :paginator="$branches" />

        @include('dashboard.branches.create')
        @include('dashboard.users.changePassword')
    @endsection

    @section('scripts')
        <script src="{{ asset('admin/dashboard/pages/branch.js') }}"></script>
        <script src="{{ asset('admin/dashboard/pages/delete.js') }}"></script>
        <script src="{{ asset('admin/dashboard/pages/restore.js') }}"></script>
        <script src="{{ asset('admin/dashboard/pages/toggle.js') }}"></script>
        <script src="{{ asset('admin/dashboard/pages/changePassword.js') }}"></script>
    @endsection
