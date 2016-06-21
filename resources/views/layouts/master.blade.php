<html>

<title>Tatekae @yield('title', '')</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.0.28/css/bulma.css">
<body class="layout-default">
<section class="hero is-light is-bold @yield('section-option', '')">
    <div class="hero-head">
        <div class="container">
            <nav class="nav">
                <div class="nav-left nav-menu">
                    <a class="nav-item is-active" href="{{url('/tatekae')}}">
                        Tatekae
                    </a>
                </div>
                <div class="nav-right nav-menu">
                    @if (Auth::check())
                        <a class="nav-item is-active" href="{{url('/tatekae')}}">
                            {{Auth::user()->screen_name}}
                        </a>
                        <a class="nav-item is-active" href="{{url('/logout')}}">
                            Logout
                        </a>
                    @else
                        <a class="nav-item is-active" href="{{url('/register')}}">
                            登録
                        </a>
                        <a class="nav-item is-active" href="{{url('/login')}}">
                            ログイン
                        </a>
                    @endif

                </div>
            </nav>
        </div>
    </div>
    @yield('hero-body', '')
</section>

@yield('content', '')

</body>
</html>