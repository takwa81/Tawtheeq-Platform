<!DOCTYPE HTML>
<html lang="ar">

<head>
    <meta charset="utf-8">
    <title>منصة توثيق</title>
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
                    <h2 class="card-title mb-4 text-center " id="card-title">تسجيل الدخول لمنصة توثيق</h2>

                    <form method="POST" action="{{ route('dashboard.login') }}">
                        @csrf
                        <div class="mb-3">
                            <label>رقم الموبايل<b class="text-danger">*</b></label>
                            <input class="form-control mt-1" name="phone" placeholder="أدخل رقم الموبايل"
                                type="text" value="{{ old('phone') }}">
                            @error('phone')
                                <x-validation-message :message="$message" />
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label>كلمة المرور <b class="text-danger">*</b></label>
                            <input class="form-control mt-1" name="password" placeholder="أدخل كلمة المرور"
                                type="password">
                            @error('password')
                                <x-validation-message :message="$message" />
                            @enderror
                        </div>

                        <div class="my-4">
                            <button type="submit" class="btn bg-main w-100 text-light" style="">تسجيل الدخول</button>
                        </div>
                    </form>

                </div>
            </div>
        </section>

        <footer class="main-footer text-center">
            <p class="font-xs">
                <script>
                    document.write(new Date().getFullYear())
                </script> ©Tawtheeq Platform- All rights reserved.
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
