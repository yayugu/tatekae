<html>

<title>App Name - @yield('title')</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.0.28/css/bulma.css">
<body class="layout-default">
<section class="hero is-primary is-bold">
    <div class="hero-head">
        <div class="container">
            <nav class="nav">
                <div class="nav-left nav-menu">
                    <a class="nav-item is-active" href="{{url('/tatekae')}}">
                        Tatekae
                    </a>
                </div>
                <div class="nav-right nav-menu">
                    <a class="nav-item is-active" href="{{url('/tatekae')}}">
                        {{Auth::user()->email}}
                    </a>
                    <a class="nav-item is-active" href="{{url('/logout')}}">
                        Logout
                    </a>
                </div>
            </nav>
        </div>
    </div>
</section>
</body>

@yield('content')

</html>