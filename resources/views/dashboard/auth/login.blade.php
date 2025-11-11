<!DOCTYPE HTML>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <title>{{ __('dashboard.platform_name') }}</title>
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/logo-tawtheeq.png') }}">
    <link href="{{ asset('assets/css/main.css') }}" rel="stylesheet" type="text/css" />
    <!-- toastr css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
</head>

<body>
    <main>
        <section class="content-main">
            <div class="card mx-auto card-login mt-60" id="login-card">
                <div class="text-center mt-20">
                    <img src="{{ asset('assets/images/logo-tawtheeq.png') }}" class="img-fluid" alt=""
                        style="width:30%; height:50%">
                </div>
                <div class="card-body">
                    <h2 class="card-title mb-4 text-center" id="card-title">{{ __('dashboard.login_title') }}</h2>

                    <form method="POST" action="{{ route('dashboard.login') }}" style="direction: ltr">
                        @csrf
                        <div class="mb-3">
                            <label>{{ __('dashboard.phone') }}<b class="text-danger">*</b></label>
                            <input class="form-control mt-1" name="phone" placeholder="{{ __('dashboard.enter_phone') }}"
                                type="text" value="{{ old('phone') }}">
                            @error('phone')
                                <x-validation-message :message="$message" />
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label>{{ __('dashboard.password') }} <b class="text-danger">*</b></label>
                            <input class="form-control mt-1" name="password" placeholder="{{ __('dashboard.enter_password') }}"
                                type="password">
                            @error('password')
                                <x-validation-message :message="$message" />
                            @enderror
                        </div>

                        <div class="my-4">
                            <button type="submit" class="btn bg-main w-100 text-light">
                                {{ __('dashboard.login') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </section>

        <footer class="main-footer text-center">
            <p class="font-xs">
                <script>
                    document.write(new Date().getFullYear())
                </script> © {{ __('dashboard.platform_name') }} - {{ __('dashboard.all_rights_reserved') }}
            </p>
        </footer>
    </main>

    <!-- Scripts -->
    <script src="{{ asset('assets/js/vendors/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/vendors/jquery.fullscreen.min.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- toastr js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

</body>

</html>
