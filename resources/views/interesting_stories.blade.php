<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="{{ asset('/assets/css/style_new.css') }}">
  <link rel="icon" type="image/png" href="./assets/favicon/favicon.png">

  <style>
    .modal-dialog{
      max-width: 80%;
    }
  </style>
  <title>News</title>
</head>

<body>


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


  <div class="news">
    <!-- header starts -->
    <nav class="navbar navbar-expand-lg navbar-dark">
      <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
          <img src="./assets/logo/logo-white.png" alt="Logo" width="190" />
        </a>

        <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-bs-toggle="offcanvas" data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
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
        <a href="{{ route('logout') }}" class="btn btn-secondary max_contant" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
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

    <!-- header ends  -->

    <h2 class="centered_h1_bold_2 p-4">News</h2>

  </div>



  <!-- news section starts  -->

  <div class="container ">
    <div class="row p-4 mt-5 mb-5 rounded-4 news_box">




      @forelse ($stories as $story)
      <div class="col-md-4 col-12 col-sm-6 col-lg-4 d-flex align-items-center justify-content-center mb-3">
        <div class="card shadow" onclick="addUrl('{{ $story->url }}','{{ $story->title }}')" style="width: 18rem;">
          <img src="{{ env('APP_URL')."storage/".$story->image }}" class=" card-img-top" alt="...">
          <div class="card-body">
            <h6 class="card-text" title="{{ $story->title }}">{{ Str::limit($story->title, 55) }}.</h6>
          </div>
        </div>
      </div>
      @empty
      <div class="col-md-3 mb-3">
        <h5 class="card-title">No Stories</h5>
      </div>
      @endforelse


    </div>
  </div>

  <!-- news section end  -->

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
            <iframe id="iframeDiv" src="" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
          </div>
        </div>

      </div>
    </div>
  </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
</script>
<script>
  function addUrl(url, title) {
    document.getElementById('iframeDiv').src = url;
    document.getElementById('exampleModalLabel').innerHTML = title;
    var myModal = new bootstrap.Modal(document.getElementById("exampleModal"), {});
    myModal.show();
  }
</script>

</html>
