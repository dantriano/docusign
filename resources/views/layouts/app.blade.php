<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="{{asset('css/app.css')}}" rel="stylesheet">
</head>

<body>
    <nav class="navbar navbar-dark bg-dark navbar-expand-lg mb-5">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Docusign</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="d-flex justify-content-between" id="navbarScroll">
                <div class="collapse navbar-collapse ">

                    @auth
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName()=='dashboard' ? 'active': '' }}" {{ Route::currentRouteName()=='dashboard' ? 'aria-current="page"': '' }} href="{{ route('dashboard') }}">{{__('messages.my_requests')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ Route::currentRouteName()=='documentos' ? 'active': '' }}" {{ Route::currentRouteName()=='documentos' ? 'aria-current="page"': '' }} href="{{ route('documentos') }}">{{__('messages.manager_docs')}}</a>
                        </li>
                    </ul>
                    @endauth
                </div>
                <div class="">
                    <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Config::get('languages')[App::getLocale()] }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarScrollingDropdown">
                                @foreach (Config::get('languages') as $lang => $language)
                                @if ($lang != App::getLocale())
                                <li><a class="dropdown-item" href="{{ route('lang.switch', $lang) }}">{{$language}}</a></li>
                                @endif
                                @endforeach
                            </ul>
                        </li>
                        @auth
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="btn btn-outline-danger" type="submit">{{ __('messages.logout') }}</button>
                            </form>
                        </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div> <!-- /container -->
    <script src="{{asset('js/app.js')}}"></script>
</body>

</html>