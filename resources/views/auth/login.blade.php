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

    <title>Log in</title>
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
              <a class="nav-link text-dark" href="{{ route('about_page') }}">About</a>
            </li>
            </ul>

            <!-- <div>
              <a href="/signup.html" class="btn btn-outline-primary max_contant">Sign Up</a>
              <a href="/login.html" class="btn btn-secondary max_contant">Login</a>
            </div> -->
          </div>
        </div>
        <!-- header ends  -->

        <!-- hero section starts  -->

        <div class="container-fluid set-width-100 mx-auto my-auto">
            <div ></div>
                <div class="main_signUp m-5">
                    <h1 class="regiter_heading_main text-center p-4 w-100">Login</h1>
                    <form class="row p-4" action="{{ route('login') }}" method="post">
                        @csrf
                        <div class="col-md-6">
                            <div>
                                <label for="email" class="form-label font_wright_500">Email
                                    Address</label>
                                <input class="form-control" name="email" placeholder="Email" type="email" id="email"
                                    class="@error('email') is-invalid @enderror" value="{{ old('email') }}" required
                                    autocomplete="email" autofocus>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div>
                                <label for="password" class="form-label">Password</label>
                                <input class="form-control" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
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
          </div>

        <!-- hero section ends  -->
      </div>

</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</html>


    {{-- <section class="back_sign__ login__ py-3">
        <div class="container-fluid">
            <div class="col-md-8  m-auto">
                <div class="main_signUp">
                    <h1 class="regiter_heading_h">Login</h1>
                    <div class="row">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="col-md-12">
                                <div>

                                    <div>
                                        <div class="row justify-content-center">
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input class="form-control" id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="Email">
                                                    @error('email')
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="mb-3">
                                                    <label for="password" class="form-label">Password</label>
                                                    <input class="form-control" id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Password">
                                                    @error('password')
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
                                                    <button type="submit" class="btn submit_btn">Login</button>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="col-md-6"></div>
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
