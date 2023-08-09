<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="og:image:width" content="100" />
    <meta property="og:image:height" content="100" />
    <meta property="og:image" content="{{asset('image/sm_logo.png')}}"/>
    <link rel="shortcut icon" href="{{asset('image/sm_logo.png')}}" type="image/x-icon">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!--   semantic ui    -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/semantic.min.css') }}">
    <script
        src="https://code.jquery.com/jquery-3.1.1.min.js"
        integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
        crossorigin="anonymous">
    </script>
    <script src="{{ asset('js/semantic.min.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/variable.js') }}"></script>
    <!--    alpinejs    -->
    <script src="{{ asset('js/alpine.js') }}" defer></script>
</head>
<body>

    <div class="his-container-spinner" id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">

                <a class="navbar-brand border border-warning rounded" href="{{ url('/') }}">
                    <img src="{{ asset('image/title_logo.png') }}" class="m-1" width="32px" height="32px">
                    <span class="me-1">{{ config('app.name', 'Laravel') }}</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">
                        <li>
                            <a title="Tải một ảnh" data-medium="Menu-TaiMotAnh" class="btn btn-primary me-3" id="new_free_image"></a>
                        </li>
                        <li>
                            <a title="Tải nhiều ảnh" data-medium="Menu-TaiNhieuAnh" class="btn btn-primary me-3" id="new_free_image_multipart"></a>
                        </li>
                        <li>
                            <a title="Tải video" data-medium="Menu-TaiVideo" class="btn btn-primary me-3" id="new_free_video"></a>
                        </li>
                        <li>
                            <a title="Tải file" data-medium="Menu-TaiFile" class="btn btn-primary me-3" id="new_free_file"></a>
                        </li>
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
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @php
                                      $value = Auth::user();
                                    @endphp

                                    @if( $value->avatar_upload == null || $value->avatar_upload  == "")
                                        <img class="rounded-circle" src="{{Auth::user()->avatar}}" style="max-width: 40px; max-height: 40px"/>
                                    @else
                                        <img class="rounded-circle" src="{{Auth::user()->avatar_upload}}"  style="max-width: 40px; max-height: 40px"/>
                                    @endif

                                    {{ Auth::user()->name }}

                                </a>

                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('user') }}">
                                        Thông tin
                                    </a>
                                    <a class="dropdown-item fw-bold" href="{{ route('history_upload') }}">
                                        Lịch sử upload
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Đăng xuất') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-3 scroll-none-width">
            @yield('content')
        </main>
    </div>

    <div class="his-spinner all-center" id="spinner_container_page">
        <div class="his-content-spinner all-center">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            <span class="m-2" id="spinner_container_page_lable">Loading...</span>
        </div>
    </div>
</body>
<footer id="footer" class="d-flex justify-content-center align-items-center text-center">
        Copyright All Rights Reserved @2022 By Free Image
</footer>
</html>

<script>
    function GetDataImage(){
        axios.get('/api/user/image')
            .then(function (response) {
                // handle success
                var payload = CheckArrayOrObjectBindData(response.data);
                console.log(payload);

                var src = document.getElementById("bind_avatar");
                src.setAttribute("src", payload.avatar_upload);
            })
            .catch(function (error) {
                // handle error
                console.log(error);
            })
            .then(function () {
                // always executed
            });
    }

    MenuNav("new_free_image", "{{route('free_image')}}", "Tải Một Ảnh");
    MenuNav("new_free_image_multipart", "{{route('free_image_multipart')}}", "Tải Nhiều Ảnh");
    MenuNav("new_free_video", "{{route('free_video')}}", "Tải Video");
    MenuNav("new_free_file", "{{route('free_file')}}", "Tải File");
</script>
