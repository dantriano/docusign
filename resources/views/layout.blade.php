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
    <!-- Static navbar -->

    <nav class="navbar navbar-dark bg-dark navbar-expand-lg mb-5">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Docusign</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 100px;">
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName()=='dashboard' ? 'active': '' }}" {{ Route::currentRouteName()=='dashboard' ? 'aria-current="page"': '' }}  href="{{ route('dashboard') }}">{{__('messages.my_docs')}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ Route::currentRouteName()=='manager' ? 'active': '' }}" {{ Route::currentRouteName()=='manager' ? 'aria-current="page"': '' }} href="{{ route('manager') }}">{{__('messages.manager_docs')}}</a>
                    </li>
                </ul>
                <ul class="d-flex">

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Config::get('languages')[App::getLocale()] }}
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
                            @foreach (Config::get('languages') as $lang => $language)
                            @if ($lang != App::getLocale())
                            <li><a class="dropdown-item" href="{{ route('lang.switch', $lang) }}">{{$language}}</a></li>
                            @endif
                            @endforeach
                        </ul>
                    </li>
                </ul>
                <form class="d-flex">

                    <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                    <button class="btn btn-outline-success" type="submit">Search</button>

                </form>
            </div>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div> <!-- /container -->
    <script src="{{asset('js/app.js')}}"></script>
</body>

</html>