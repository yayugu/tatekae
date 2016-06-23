<html>

<title>Tatekae @yield('title', '')</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.0.28/css/bulma.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
<body class="layout-default">
<section class="hero is-bold @yield('section-option', '')">
    <div class="hero-head">
        <div class="container">
            <nav class="nav">
                <div class="nav-left">
                    <a class="nav-item is-active" href="{{url('/tatekae')}}">
                        Tatekae
                    </a>
                </div>
                <div class="nav-center">
                </div>
                <span id="nav-toggle" class="nav-toggle">
                    <span></span>
                    <span></span>
                    <span></span>
                </span>
                <div id="nav-menu" class="nav-right nav-menu">
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="{{url('/tatekae.js')}}"></script>


</body>
</html>