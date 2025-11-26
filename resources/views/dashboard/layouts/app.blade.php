<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <title>{{ __('dashboard.site_title') }}</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo-tawtheeq.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/hystmodal@1.0.1/dist/hystmodal.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    @if (app()->getLocale() == 'en')
        <link href="{{ asset('assets/css/main-en.css') }}" rel="stylesheet" type="text/css" />
    @else
        <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" type="text/css" />
    @endif

    {{-- <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" type="text/css" /> --}}
    <link href="{{ asset('assets/css/toastr.min.css') }}" rel="stylesheet" type="text/css" />

    @yield('styles')
    <style>
        /* select2 */

        .select2-selection__clear {
            display: none !important;
        }

        .select2 .select2-container .select2-container--bootstrap {
            background-color: #f4f5f9;
            border: 2px solid #f4f5f9 !important;
        }

        .select2-selection.select2-selection--multiple {
            background-color: #f4f5f9 !important;
            border: 2px solid #f4f5f9 !important;
            font-size: 13px !important;
            -webkit-box-shadow: none !important;
            box-shadow: none !important;
            padding-left: 20px !important;
            color: #4f5d77 !important;
            width: 100% !important;
            border-radius: 4px !important;
            /* height: 45px !important; */
            direction: ltr !important;
            text-align: left;
        }

        .select2-selection__rendered {
            display: flex !important;
        }

        .select2-selection__choice {
            margin: 0.5rem !important;
            background: #487d61 !important;
            color: #fff !important;
            padding: 0.3rem !important;
            border-radius: 5px !important;
        }


        /*  */
        .card.shadow-sm.pet {
            box-shadow: 0 0.1rem 0.25rem rgb(167 152 255 / 92%) !important;
        }

        .menu-aside .menu-item.active .icon {
            color: #fff;
        }

        .btn.btn-md {
            padding: 0.2rem 0.5rem;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
            color: white !important;
            font-weight: bold !important;
            margin: 4px !important
        }

        .select2-container--default .select2-selection--multiple .select2-selection__rendered li {
            background: var(--primary-color) !important;
            color: white !important;
            font-weight: bold !important;

        }

        .select2-container--default .select2-results__option[aria-selected="true"] {
            background-color: #d5d3d3 !important;
        }

        .select2-container--default.select2-container--focus .select2-selection--multiple,
        .select2-container--default .select2-selection--multiple {
            border: none !important;
            background: inherit !important;
        }

        .form-select:disabled {
            color: #141516;
            background-color: #e9ecef;
        }

        .select2-container {
            border: 1px solid #ddd1d1 !important;
            direction: rtl !important;
            text-align: right !important;
        }

        .select2-selection__clear {
            display: none !important;
        }

        .select2-container--default .select2-selection--single {
            border-radius: 0px 0 0 0px !important;
            border: 1px !important;
        }

        .select2-search__field {
            text-align: right !important;
        }

        .select2-container {
            width: 100%;
            background-color: #eaecf0;
            border: 2px solid #f4f5f9;
            font-size: 13px;
            -webkit-box-shadow: none;
            box-shadow: none;
            padding-left: 20px;
            color: #4f5d77;
            width: 100%;
            border-radius: 4px;
            height: 45px;
        }

        .select2-container--default .select2-selection--single {
            border: none !important;
            background: inherit !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 44px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 8px !important
        }

        .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: inherit !important;
        }

        .select2-container--open {
            border: none !important;
            background: inherit !important;
        }
    </style>
</head>

<body>
    <div class="screen-overlay"></div>
    <aside class="navbar-aside" id="offcanvas_aside">
        <div class="aside-top">
            <div>
                <button class="btn btn-icon btn-aside-minimize"> <i class="text-muted material-icons md-menu_open"></i>
                </button>
            </div>
            <a href="" class="brand-wrap">
                <img src="{{ asset('assets/images/logo-tawtheeq.png') }}" class="logo" alt="Tawtheeq Platform">
            </a>

        </div>
        <nav>
            @if (auth()->check())
                @switch(auth()->user()->role)
                    @case('super_admin')
                        @include('dashboard.layouts.sidebars.admin')
                    @break

                    @case('branch_manager')
                        @include('dashboard.layouts.sidebars.branch_manager')
                    @break

                    @case('branch')
                        @include('dashboard.layouts.sidebars.branch')
                    @break

                    @default
                        <ul class="menu-aside">
                            <li class="menu-item">
                                <span class="text text-muted">لا يوجد صلاحيات لعرض القائمة</span>
                            </li>
                        </ul>
                @endswitch
            @endif
        </nav>

    </aside>
    <main class="main-wrap">
        <header class="main-header navbar">
            <div class="col-search">

            </div>
            <div class="col-nav">
                <button class="btn btn-icon btn-mobile me-auto" data-trigger="#offcanvas_aside"> <i
                        class="material-icons md-apps"></i> </button>
                <ul class="nav">

                    @php
                        $currentLang = session('app_locale', app()->getLocale());
                        $availableLangs = [
                            'en' => 'English',
                            'ar' => 'عربي',
                        ];
                    @endphp

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" role="button"
                            title="{{ __('dashboard.language') }}">
                            <i class="material-icons md-flag"></i> {{ strtoupper($currentLang) }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end">
                            @foreach ($availableLangs as $code => $label)
                                @if ($code !== $currentLang)
                                    <a class="dropdown-item" href="{{ route('dashboard.switch.lang', $code) }}">
                                        {{ $label }}
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('dashboard.clear.cache') }}" class=""
                            title="{{ __('dashboard.clear_cache') }}">
                            <i class="material-icons md-cached"></i>
                        </a>
                    </li>
                    <li class="dropdown nav-item">
                        <a class="dropdown-toggle align-middle" data-bs-toggle="dropdown" href="#"
                            id="dropdownAccount" aria-expanded="false">{{ __('dashboard.welcome') }},
                            {{ auth()->user()->full_name }}
                        </a>
                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownAccount">
                            <a class="dropdown-item" href=""><i class="material-icons md-perm_identity"></i>
                                {{ __('dashboard.account_info') }}</a>
                            <form action="{{ route('dashboard.logout') }}" class="dropdown-item text-danger"
                                method="POST">
                                @csrf
                                <button class="btn btn-sm text-danger p-0" type="submit"><i
                                        class="material-icons md-exit_to_app"></i>{{ __('dashboard.logout') }}</button>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </header>
        <section class="content-main" style="min-height: calc(100vh - 165px) !important; ">
            @yield('content')
        </section>

        <footer class="main-footer font-xs" style="">
            <div class="row">
                <div class="col-sm-6">
                    {{ __('dashboard.footer_rights_year', ['year' => date('Y')]) }}
                </div>
            </div>
        </footer>

    </main>
    {{-- <script src="{{ asset('assets/js/toastr.min.js') }}" type="text/javascript"></script> --}}

    <script src="{{ asset('assets/js/sweetalert2.all.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/vendors/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/select2.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/jquery.fullscreen.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/chart.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/js/custom-chart.js') }}" type="text/javascript"></script>
    <script src="{{ asset('vendor/flasher/toastr.min.js') }}"></script>
    <script>
        window.translations = {
            delete_confirm_title: "{{ __('dashboard.delete_confirm_title') }}",
            delete_confirm_text: "{{ __('dashboard.delete_confirm_text') }}",
            delete_confirm_yes: "{{ __('dashboard.delete_confirm_yes') }}",
            delete_confirm_cancel: "{{ __('dashboard.delete_confirm_cancel') }}",
            delete_success: "{{ __('messages.deleted_successfully') }}",
            delete_error: "{{ __('messages.delete_failed') }}",
            toggle_activate_title: "{{ __('dashboard.toggle_activate_title') }}",
            toggle_deactivate_title: "{{ __('dashboard.toggle_deactivate_title') }}",
            toggle_confirm_text: "{{ __('dashboard.toggle_confirm_text') }}",
            toggle_yes: "{{ __('dashboard.toggle_yes') }}",
            toggle_cancel: "{{ __('dashboard.toggle_cancel') }}",
            toggle_success: "{{ __('messages.updated_successfully') }}",
            toggle_error: "{{ __('messages.update_failed') }}",
            status_active: "{{ __('dashboard.active') }}",
            status_inactive: "{{ __('dashboard.inactive') }}",
        }
    </script>

    <script>
        toastr.options = {!! json_encode(config('toastr.options')) !!};

        @if (session('success'))
            toastr.success("{{ session('success') }}");
        @endif

        @if (session('error'))
            toastr.error("{{ session('error') }}");
        @endif
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const sidebar = document.getElementById("offcanvas_aside");
            const savedScroll = sessionStorage.getItem("sidebar-scroll");
            if (savedScroll) {
                sidebar.scrollTop = parseInt(savedScroll, 10);
            }

            // حفظ الموضع عند كل scroll
            sidebar.addEventListener("scroll", function() {
                sessionStorage.setItem("sidebar-scroll", sidebar.scrollTop);
            });
        });
    </script>
    @yield('scripts')
</body>

</html>
