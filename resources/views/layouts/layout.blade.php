<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/toastr/build/toastr.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fontawesome/css/fontawesome.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fontawesome/css/all.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/fontawesome/css/fontawesome.css')}}">
    <!-- Scripts -->
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{route('categories.index')}}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <div class="dropdown">
                            <a type="button" class="dropdown-toggle" data-toggle="dropdown" style="text-decoration: none; color: black">
                                {{ Auth::user()->name }}
                            </a>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>

                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    <!-- The Modal -->
    <div class="modal" id="ModalDelete" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Are you sure you want to delete this category</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <form action="" method="POST" style="width: 100%" class="d-flex justify-content-between">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-success">Yes</button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-2 mt-4">
                <nav class="nav flex-column">
                    <a class="nav-link {{isset($page_category)?$page_category:''}}" href="{{route('categories.index')}}">Categories</a>
                    <a class="nav-link {{isset($page_page)?$page_page:''}}" href="{{route('pages.index')}}">Pages</a>
                    <a class="nav-link {{isset($page_product)?$page_product:''}}" href="{{route('products.index')}}">Products</a>
                    <a class="nav-link btn btn-success " href="{{route('api_documentation')}}">Api documentation</a>
                    <span>if Api documentation will not work. Open terminal end run <b>php artisan serve</b> command then it will work</span>
                </nav>
            </div>
            <div class="col-10">
                <main class="py-4">
                    @yield('content')
                </main>
            </div>
        </div>
    </div>
</div>
</body>
<script src="{{asset('assets/js/jquery.slim.min.js')}}"></script>
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('assets/toastr/build/toastr.min.js')}}"></script>
<script src="{{asset('assets/toastr/toastr.js')}}"></script>
<script src="{{asset('assets/fontawesome/js/fontawesome.min.js')}}"></script>
<script src="{{asset('assets/fontawesome/js/all.min.js')}}"></script>
<script>
    let sessionSuccess ="{{session('status')}}";
    if(sessionSuccess){
        toastr.success(sessionSuccess)
    }
</script>
<script>
    $(document).ready(function () {
        $(document).on('click', '.delete-datas', function(e) {
            var url = $(this).attr('data-url')
            $('#ModalDelete').find('form').attr('action', url)
        })
    })
</script>
</html>
