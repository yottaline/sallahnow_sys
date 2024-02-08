<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login | Dashboard</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.rtl.min.css" rel="stylesheet" integrity="sha384-nU14brUcp6StFntEOOEBvcJm4huWjB0OcIeQ3fltAfSmuZFrkAif0T+UtNGlKKQv" crossorigin="anonymous"> -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css" />

    <link rel="stylesheet" href="/assets/css/style.css?v=1.0.0">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />


    <!-- Scripts -->
    <script async src="https://www.google.com/recaptcha/api.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        #cards-container {
            min-width: 400px;
        }

        .logo {
            display: inline-block;
            height: 100px;
            width: 100px;
            background-image: url(/favico.png);
            background-position: center;
            background-repeat: no-repeat;
            background-size: contain;
        }
    </style>
</head>

<body class="font-sans text-gray-900 antialiased">
    <div class="d-flex h-100">
        <div id="cards-container" class="bg-muted-8 flex-grow-1 flex-md-grow-0">
            <div class="mt-5 text-center">
                <div class="logo"></div>
                <h6 class="m-0">Yottaline Dashboard</h6>
            </div>

            <div id="login-card" class="card border-0 mt-5 bg-muted-8">
                <div class="card-body">
                    <form id="login-form" action="#" method="post" role="form">
                        @csrf
                        <div class="mb-3 position-relative">
                            <label for="login-email">Email<b class="text-danger">&ast;</b></label>
                            <input id="login-email" name="email" type="email" class="form-control" required>
                        </div>
                        <div class="mb-3 position-relative">
                            <label for="login-email">Password<b class="text-danger">&ast;</b></label>
                            <input id="login-password" name="password" type="password" class="form-control" required>
                        </div>

                        <div class="g-recaptcha mt-4" data-sitekey={{ config('services.recaptcha.key') }}></div>

                        @if (Route::has('password.request'))
                            <small class="d-block my-3"><i class="bi bi-lock text-muted"></i> <a
                                    href="{{ route('password.request') }}" target="_self">Forgot your
                                    password?</a></small>
                        @endif

                        <input type="hidden" name="token" value="0">
                        <input type="hidden" name="action" value="login_form">
                        <div class="text-center">
                            <button type="submit" class="btn btn-outline-dark rounded-pill mb-3 px-5">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="bg-img-cover d-none d-md-block flex-grow-1 bg-dark"
            style="background-image: url(/assets/img/login_bg.jpg)"></div>
    </div>
</body>

</html>
