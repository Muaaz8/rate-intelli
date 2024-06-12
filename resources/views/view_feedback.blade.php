<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('/assets/css/style_new.css') }}">
    <link rel="icon" type="image/png" href="./assets/favicon/favicon.png">

    <title>Feedback</title>
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

        <!-- feedback section starts  -->

        <div class="container mt-5 mb-5">
            <div class="feedback-form">
           <h1 class="regiter_heading_main text-center p-4 w-100">Feedback</h1>
           <form class="p-4" action="{{ route('post_feedback') }}" method="post" enctype="multipart/form-data" class="m-2">
            @if(session()->has('success'))
            <div class="alert alert-success m-2 text-center">
                {{ session()->get('success') }}
            </div>
        @endif
        @csrf
             <div class="form-group mb-2">
               <label for="name">Your Name</label>
               <input type="text" name="name" class="form-control" id="name" required>
             </div>
             <div class="form-group mb-2">
               <label for="email">Email Address</label>
               <input type="email" name="email" class="form-control" id="email" required>
             </div>
             <div class="form-group mb-2">
               <label for="message">Your Message</label>
               <textarea class="form-control" name="message" id="message" required></textarea>
             </div>
             <button type="submit" class="btn gradient btn-primary">Submit Feedback</button>
           </form>
         </div>
       </div>

        <!-- feedback section ends  -->
      </div>


    @include('footer')

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div>
                        <iframe
                            id="iframeDiv"
                            src=""
                            width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"
                            ></iframe>
                    </div>
                </div>

            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
</html>
