<!-- header starts here  -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="#"><img src="{{ asset('img/logo-1.png') }}" width="180" alt=""></a>

        <button class="navbar-toggler text-light border-white" type="button" data-toggle="collapse"
            data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
    </div>

    <div class="collapse navbar-collapse">
        <ul class="navbar-nav mb-2">
            <li class="nav-item mx-2 navbar-link">
                <a class="nav-link active text-light" aria-current="page" href="{{ \Request::path()=='/'?'#':'/' }}">Home</a>
            </li>
            <li class="nav-item mx-2 navbar-link">
                <a class="nav-link text-light" href="{{ \Request::path()=='/'?'#about':'/#about' }}">About</a>
            </li>
            <li class="nav-item mx-2 navbar-link">
                <a class="nav-link text-light" href="{{ \Request::path()=='/'?'#products':'/#products' }}">Products</a>
            </li>
            <li class="nav-item mx-2 navbar-link">
                <a class="nav-link text-light" href="{{ \Request::path()=='/'?'#plans':'/#plans' }}">Plans</a>
            </li>
            {{-- <li class="nav-item mx-2 navbar-link">
                <a class="nav-link text-light" href="#feedback">Feedback</a>
            </li> --}}
            @if (Auth::check())
            <li class="nav-item mx-2 w-100">
                <a class="btn btn-outline-light" style="width: max-content;" href="{{ route('home') }}">Go To Dashboard</a>
            </li>

            <li class="nav-item mx-2 w-100">
                <a href="{{ route('logout') }}" class="btn btn-outline-light"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
            @else
                <li class="nav-item mx-2 w-100">
                    <a class="btn btn-outline-light" style="width: max-content;" href="{{ url('/signin') }}">Login / Signup</a>
                </li>
            @endif
                {{-- <a class="btn btn-outline-light" style="width: max-content;" href="./login-signup.html">Login / Signup</a> --}}
        </ul>

    </div>

</nav>
<div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
    <div class="offcanvas-header">
        <a class="offcanvas-title" id="offcanvasNavbarLabel"><img src="{{ asset('img/logo-1.png') }}" width="180"
                alt=""></a>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body text-dark">

        <ul class="navbar-nav mb-2">
            <li class="nav-item mx-2 navbar-link">
                <a class="nav-link active" aria-current="page" href="#">Home</a>
            </li>
            <li class="nav-item mx-2 navbar-link">
                <a class="nav-link" href="#about">About</a>
            </li>
            <li class="nav-item mx-2 navbar-link">
                <a class="nav-link" href="#products">Products</a>
            </li>
            <li class="nav-item mx-2 navbar-link">
                <a class="nav-link" href="#plans">Plans</a>
            </li>
            {{-- <li class="nav-item mx-2 navbar-link">
                <a class="nav-link" href="#feedback">Feedback</a>
            </li> --}}

        </ul>

        <div>
            <a class="btn my-btn-outline-secondary" href="./login-signup.html">Login / Signup</a>
        </div>
    </div>
</div>
<!-- header ends here  -->
