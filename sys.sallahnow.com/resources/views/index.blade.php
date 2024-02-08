<!DOCTYPE html>
<html lang="en" dir="ltr">

@include('layouts.header')

<body id="page-top">
    <nav class="navbar navbar-expand-md navbar-dark bg-dark px-2 fixed-top">
        <div class="d-flex w-100 align-items-center">
            <div class="me-auto">
                <a class="h5 bi bi-list link-light p-2 m-0 me-3" role="button" data-bs-toggle="offcanvas"
                    data-bs-target="#navOffcanvas" aria-controls="navOffcanvas"></a>
                <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Dashboard</a>
            </div>
            <form action="" method="get" role="search">
                <input type="search" name="q" class="form-control my-3 my-md-0 rounded-pill"
                    placeholder="Search..." value="">
            </form>
        </div>
    </nav>

    @include('layouts.sidebar')

    <div id="wrapper">
        @yield('content')
    </div>

    @include('layouts.footer')''
</body>

@yield('js')

</html>
