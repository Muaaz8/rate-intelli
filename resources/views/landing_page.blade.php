<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('/assets/css/style_new.css') }}">
    <link rel="icon" type="image/png" href="./assets/favicon/favicon.png">
    <title>Sign Up</title>
  </head>
  <body>
    <div class="signup">
        <!-- header starts -->
        <nav class="navbar navbar-expand-lg navbar-dark">
          <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
              <img src="./assets/logo/logo-white.png" alt="Logo" width="190" />
            </a>

            <button
              class="navbar-toggler navbar-dark"
              type="button"
              data-toggle="collapse"
              data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation"
            >
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

              <ul class="navbar-nav">
                <li class="nav-item">
                  <a class="nav-link text-white" href="{{ url('/') }}">Home</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-white" href="{{ route('interesting_stories') }}">News</a>
                </li>
                <li class="nav-item">
                  <a class="nav-link text-white" href="{{ route('view_feedback') }}">Feedback</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white" href="{{ route('about_page') }}">About</a>
                </li>
              </ul>
            </div>

          </div>

          <div class="collapse navbar-collapse mx-2">
              @if(Auth::check())
                  <button onclick="window.location.href='/home'" class="btn btn-outline-light max_contant">Go To
                      Dashboard</button>
                  <a href="{{ route('logout') }}" class="btn btn-secondary max_contant"
                  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                      {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
              @else
                  <button onclick="window.location.href='/signup'" class="btn btn-outline-light max_contant">Sign Up Now</button>
                  <button onclick="window.location.href='/signin'" class="btn btn-secondary max_contant">Login</button>
              @endif

          </div>

        </nav>

        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasNavbar" aria-labelledby="offcanvasNavbarLabel">
          <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasNavbarLabel">INTELLI-RATE</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body text-dark">
            <ul class="navbar-nav justify-content-end pe-3">
            <li class="nav-item">
              <a class="nav-link text-dark" href="{{ url('/') }}">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" href="{{ route('interesting_stories') }}">News</a>
            </li>
            <li class="nav-item">
              <a class="nav-link text-dark" href="{{ route('view_feedback') }}">Feedback</a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white" href="{{ route('about_page') }}">About</a>
            </li>
            </ul>

            <div>
        @if(Auth::check())
        <button onclick="window.location.href='/home'" class="btn btn-outline-primary max_contant">Go To
          Dashboard</button>
        <a href="{{ route('logout') }}" class="btn btn-secondary max_contant" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
          @csrf
        </form>
        @else
        <button onclick="window.location.href='/signup'" class="btn btn-outline-primary max_contant">Sign Up Now</button>
        <button onclick="window.location.href='/signin'" class="btn btn-secondary max_contant">Login</button>
        @endif
        </div>

            <!-- <div>
              <a href="/signup.html" class="btn btn-outline-primary max_contant">Sign Up</a>
              <a href="/login.html" class="btn btn-secondary max_contant">Login</a>
            </div> -->
          </div>
        </div>
        <!-- header ends  -->

        <!-- hero section starts  -->

        <div class="container-fluid  set-width-100 mx-auto my-auto">
            <div ></div>
                <div class="main_signUp m-5">
                    <h1 class="regiter_heading_main text-center p-4 w-100">Login</h1>
                    @if (session('approval'))
                        <div class="col-sm-12">
                            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                                {!! session('approval') !!}
                            </div>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="col-sm-12">
                            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif
                    <form class="row p-4" action="{{ route('bank_login') }}" method="post">
                        @csrf
                        <div class="col-md-12">
                        <div >
                            <label for="email" class="form-label font_wright_500">Email
                                Address</label>
                            <input class="form-control" name="email" placeholder="Email" type="email" id="email"
                                class="@error('email') is-invalid @enderror" value="{{ old('email') }}" required
                                autocomplete="email" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror

                        </div>
                    </div>
                    <div class="row">

                      <div class="col-md-12 mt-3">
                          <div class="mb-3 text-center">
                              <button type="submit" class="btn gradient btn-primary btn-lg submit_btn">Next</button>
                          </div>
                      </div>
                  </div>
                </form>
                </div>
                </div>
          </div>

        <!-- hero section ends  -->
      </div>
    <!-- <section class="back_sign__ login__ py-3">
        <div class="container-fluid">
            <div class="col-md-8  m-auto">
                <div class="main_signUp">
                    <h1 class="regiter_heading_h">Login</h1>
                    @if (session('approval'))
                        <div class="col-sm-12">
                            <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
                                {{ session('approval') }}
                            </div>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="col-sm-12">
                            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                                {{ session('error') }}
                            </div>
                        </div>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('bank_login') }}" class="login-form" id="UserLoginForm" method="post">
                                @csrf
                                <div>

                                    <div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-4">
                                                <div class="mb-3 text-center">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input class="form-control" name="email" placeholder="Email" type="email" id="email"
                                                        class="@error('email') is-invalid @enderror" value="{{ old('email') }}" required
                                                        autocomplete="email" autofocus>
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>

                                <div>
                                    <div>
                                        <div class="row">

                                            <div class="col-md-12">
                                                <div class="mb-3 text-center">
                                                    <button type="submit" class="btn submit_btn">Next</button>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="text-center mb-3">
                                            <a href="{{ route('signup') }}"> Create Account </a>
                                        </div> --}}
                                        <div class="text-center">
                                            <a href="{{ route('login') }}"> Go To Admin Login </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>
