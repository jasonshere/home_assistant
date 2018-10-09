<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'WeatherStation') }}</title>

    <!-- Scripts -->
    <!-- plugins:css -->
    <link rel="stylesheet" href="https://d3q5poti6uedt7.cloudfront.net/vendors/iconfonts/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="https://d3q5poti6uedt7.cloudfront.net/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="https://d3q5poti6uedt7.cloudfront.net/vendors/css/vendor.bundle.addons.css">
    <!-- endinject -->
    <!-- plugin css for this page -->
    <!-- End plugin css for this page -->
    <!-- inject:css -->
    <link rel="stylesheet" href="https://d3q5poti6uedt7.cloudfront.net/css/style.css">
    <!-- endinject -->
    <link rel="shortcut icon" href="https://d3q5poti6uedt7.cloudfront.net/images/favicon.png" />
    <style>
        .auth.theme-one .auto-form-wrapper .form-group .input-group .form-control, .auth.theme-one .auto-form-wrapper .form-group .input-group .form-control:focus {
            border: 1px solid #e5e5e5;
            border-radius: 6px;
        }
    </style>
</head>
<body>

      <div class="container-scroller">
        <div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
        <div class="content-wrapper d-flex align-items-center auth auth-bg-1 theme-one">
            <div class="row w-100">
            <div class="col-lg-4 mx-auto">
                <div class="auto-form-wrapper">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                    <label class="label">Email</label>
                    <div class="input-group">
                        <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                        @endif
                        
                    </div>
                    </div>
                    <div class="form-group">
                    <label class="label">Password</label>
                    <div class="input-group">
                        <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                        @if ($errors->has('password'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('password') }}</strong>
                            </span>
                        @endif
                    </div>
                    </div>
                    <div class="form-group">
                    <button class="btn btn-primary submit-btn btn-block">Login</button>
                    </div>
                    <div class="form-group d-flex justify-content-between">
                    <div class="form-check form-check-flat mt-0">
                        <label class="form-check-label" for="remember">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                {{ __('Remember Me') }}
                        </label>
                    </div>
                    </div>
                    <div class="form-group">
                        <div class="text-block text-center my-3">
                        <span class="text-small font-weight-semibold">Not a member ?</span>
                        <a href="{{ route('register') }}" class="text-black text-small">Create new account</a>
                    </div>
                </form>
                </div>
                
            </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
        </div>
        <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="https://d3q5poti6uedt7.cloudfront.net/vendors/js/vendor.bundle.base.js"></script>
    <script src="https://d3q5poti6uedt7.cloudfront.net/vendors/js/vendor.bundle.addons.js"></script>
    <!-- endinject -->
    <!-- inject:js -->
    <script src="https://d3q5poti6uedt7.cloudfront.net/js/off-canvas.js"></script>
    <script src="https://d3q5poti6uedt7.cloudfront.net/js/misc.js"></script>
    <!-- endinject -->
</body>
</html>