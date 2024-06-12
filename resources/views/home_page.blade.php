<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Intelli-Rate</title>
  <link rel="icon" type="image/png" href="./assets/favicon/favicon.png">
  <link rel="stylesheet" href="{{asset('assets/css/style_new.css')}}" />
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
  />


  <style>
    .owl-carousel .owl-item img {
      display: block;
      width: 100%;
      height: 520px;
    }

    .owl-carousel .owl-item .text-overlay {
      position: absolute;
      bottom: 20px;
      left: 0;
      right: 0;
      color: white;
    }

  </style>


</head>

<body>

  <div class="home">
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
    <!-- header ends  -->

    <!-- hero section starts  -->

    <div class="centered">
      <h1 class="centered_h1_thin">Intelli-Rate by</h1>
      <h1 class="centered_h1_bold">BancAnalytics</h1>
    </div>

    <!-- hero section ends  -->
  </div>

  <!-- cards starts  -->

  <div class="container cards_container">
    <div class="row">
      <div class="col-md-4 col-12">
        <div class="card text-white my_card shadow" style="min-height: 190px;">
          <div class="card-body text-center">
            <div class="card-title d-flex align-items-center justify-content-center">
              <h3 class="card_title">Who We Are</h3>
            </div>
            <p class="card-text card_text text-center">
              BancAnalytics was founded in 1995 by experienced banking
              executives and business professionals with a mission of
              improving data collection and analytical systems to help
              financial institutions make more timely and impactful decisions.
              {{-- <a href="#" style="text-decoration: none; color: white;">...Learn more</a> --}}
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-4 col-12">
        <div class="card text-white my_card shadow" style="min-height: 190px;">
          <div class="card-body text-center">
            <div class="card-title d-flex align-items-center justify-content-center">
              <h3 class="card_title">What We Do</h3>
            </div>
            <p class="card-text card_text text-center">
              BancAnalytics offers deposit rate intelligence reports that provide users with timely,
               accurate data on competitor rates and how their financial institution’s rates compare
                to the market. We offer broad market analyses by metropolitan area weekly.
              {{-- <a href="#" style="text-decoration: none; color: white;">...Learn more</a> --}}
            </p>
          </div>
        </div>
      </div>

      <div class="col-md-4 col-12">
        <div class="card text-white my_card shadow" style="min-height: 190px;">
          <div class="card-body text-center">
            <div class="card-title d-flex align-items-center justify-content-center">
              <h3 class="card_title">What Sets Us Apart</h3>
            </div>
            <p class="card-text card_text text-center">
              Our approach to data collection and analysis is to make sure the data is accurate, comprehensive,
               timely, and relevant to our clients’ needs.  The platform is easy to navigate and data is
               presented so that clients can quickly drill down and make critical decisions which impact the bottom line.
              {{-- <a href="#" style="text-decoration: none; color: white;">...Learn more</a> --}}
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- cards end  -->

  <!-- banner section start  -->

  <div class="container p-4 text-center">
    <h1 class="banner_heading fw-bolder blue_dark">Product Details</h1>
    <h1 class="banner_heading">
      <span class="fw-normal">Intelli-Rate by</span>
      <span class="fw-bold">BancAnalytics</span>
    </h1>
  </div>

  <div class="container-fluid bg_banner owl-carousel owl-theme">

    {{-- <div class="row item">
      <div class="col-md-6 col-lg-6">
        <img width="100%" height="600px" src="./assets/banner/banner-1.png" alt="" />
      </div>
      <div class="col-md-6 col-lg-6 d-flex align-items-center justify-content-center">
        <div class="container banner_text d-flex text-left align-items-start justify-content-center flex-column">
          <h2 class="fw-bold">Deposit Rate Survey :</h2>
          <ul class="banner_text_ul">
            <li>
              Weekly report contains personal deposit yields for various
              products including:
            </li>

            <ul>
                <li>Personal Savings/Share Accounts ($1K minimum)</li>
                <li>Money Market Deposit Accounts ($10K, $25K, $50K)</li>
                <li>Certificates of Deposit (Less than $10,000)</li>
                <li>Special Promotions</li>
            </ul>

            <li>
              This coverage enables financial institutions to gain insights
              into the competitive landscape across multiple deposit
              categories and determine how they and their competitors rank in
              each of the categories.
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="row item">
      <div class="col-md-6 col-lg-6">
        <img width="100%" height="600px" src="./assets/banner/banner-2.png" alt="" />
      </div>
      <div class="col-md-6 col-lg-6 d-flex align-items-center justify-content-center">
        <div class="container banner_text d-flex text-left align-items-start justify-content-center flex-column">
          <h2 class="fw-bold">Metropolitan Area Focus:</h2>
          <ul class="banner_text_ul">
            <li>
                Our comprehensive report focuses on significant banking institutions within a specific
                metropolitan area. This localized approach allows financial institutions to understand
                the competition and market conditions in their specific region.
            </li>
            <li>
                Custom reports are available anywhere in the nation.
            </li>
          </ul>
        </div>
      </div>
    </div>

    <div class="row item">
      <div class="col-md-6 col-lg-6">
        <img width="100%" height="600px" src="./assets/banner/banner-2.png" alt="" />
      </div>
      <div class="col-md-6 col-lg-6 d-flex align-items-center justify-content-center">
        <div class="container banner_text d-flex text-left align-items-start justify-content-center flex-column">
          <h2 class="fw-bold">Report Features:</h2>
          <ul class="banner_text_ul">
            <li>
                Annual Percentage Yield (APY) Rankings Report.
            </li>
             <ul>
              <li>Institutions are ranked high to low for each product surveyed.  Changes from previous week to current APY are indicated.</li>
              <li>Market highs, lows, mean, median, and mode are summarized for each of the products surveyed.</li>
              <li>Ability to highlight selected institutions, filter by institution type, and generate a PDF to present to the Management Team and Board Members.</li>
            </ul>

            <li>Special Promotions.</li>
             <ul><li>Products requiring higher deposit amounts or other relationships are ranked high to low by APY.</li></ul>
            <li>Summary Report.</li>
             <ul>
                <li>Determine how your institution or your competitors rank across all products in one easy to read summary.</li>
                <li>Highlight selected institutions and/or filter by institution type.</li>
            </ul>

            <li>Allow multiple members of your Management Team access through the “Manage Users” tab.</li>

          </ul>
        </div>
      </div>
    </div>

    <div class="row item">
      <div class="col-md-6 col-lg-6">
        <img width="100%" height="600px" src="./assets/banner/banner-2.png" alt="" />
      </div>
      <div class="col-md-6 col-lg-6 d-flex align-items-center justify-content-center">
        <div class="container banner_text d-flex text-left align-items-start justify-content-center flex-column">
          <h2 class="fw-bold">Peer Group Averages & Graphs </h2>
          <ul class="banner_text_ul">
            <li>
                Enables financial institutions to compare their own rates with those of similar
                institutions within the same market. This benchmarking helps institutions gauge their
                 competitiveness and performance relative to their peers.
            </li>

            <li>
                The Dashboard contains full-color graphs enhances the visual representation of data,
                 making it easier for clients to identify trends and patterns at a glance.
            </li>

          </ul>
        </div>
      </div>
    </div>

    --}}

    <div class="row item">
      <div class="col-md-6 col-lg-6">
        <img width="100%" height="600px" src="./assets/banner/banner-1.png" alt="" />
      </div>
      <div class="col-md-6 col-lg-6 d-flex align-items-center justify-content-center">
        <div class="container banner_text d-flex text-left align-items-start justify-content-center flex-column">

          <h2 class="fw-bold">Deposit Rate Survey:</h2>
          <ul class="banner_text_ul">
            <li>Weekly report contains personal deposit yields for various
              products including:</li>

          <ul>
              <li>Personal Savings/Share Accounts ($1K minimum)</li>
              <li>Money Market Deposit Accounts ($10K, $25K, $50K)</li>
              <li>Certificates of Deposit (Less than $10,000) </li>
              <li>Special Promotions </li>
          </ul>

          <li>This coverage enables financial institutions to gain insights into
              the competitive landscape across multiple deposit categories
              and determine how they and their competitors rank in each of the
              categories. </li>
            <a href="{{ route('about_page') }}#product_details">Read more</a>
          </ul>
        </div>
      </div>
    </div>

    <div class="row item">
      <div class="col-md-6 col-lg-6">
        <img width="100%" height="600px" src="./assets/banner/banner-2.png" alt="" />
      </div>
      <div class="col-md-6 col-lg-6 d-flex align-items-center justify-content-center">
        <div class="container banner_text d-flex text-left align-items-start justify-content-center flex-column">

          <h2 class="fw-bold">Metropolitan Area Focus:</h2>
          <ul class="banner_text_ul">
                    <li>Our comprehensive report focuses on significant banking
                        institutions within a specific metropolitan area. This localized
                        approach allows financial institutions to understand the
                        competition and market conditions in their specific region. </li>
                    <li>Custom reports are available anywhere in the nation. </li>
            <a href="{{ route('about_page') }}#product_details">Read more</a>
          </ul>
        </div>
      </div>
    </div>

  </div>
  </div>

  <!-- banner section ends  -->

  <!-- plan section start -->

  <div class="container p-4 text-center">
    <h1 class="banner_heading fw-bolder blue_dark">Get Started Now</h1>
    <h2 class="fw-bold">Select Your Plan</h2>

    <p class="p-3">
      The dropdown menu indicates metropolitan areas where the Standard Report
      is currently offered. Click the “Select” button, then choose your
      metropolitan area in the field below. If not listed, select a Custom
      Report and we will design a report specifically for your area with the
      institutions of your choice.
    </p>
  </div>

  <div class="container">
    <div class="row d-flex align-items-center justify-content-center">

      <!-- <div class="col-md-6 col-10">
          <div class="card-2 shadow p-4">
            <h3 class="card-title-2">Standard Metropolitan Report</h3>
            <div class="card-price-2">
              <span class="fs-1">$19.99</span>/month
            </div>
            <p class="card-description-2">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus
              ultrices lorem quis magna efficitur, eu rhoncus eros aliquet.
            </p>
            <button class="btn btn-outline-primary btn-select">Select Plan</button>
          </div>
        </div>

        <div class="col-md-6 col-10">
          <div class="card-2 shadow p-4">
            <h3 class="card-title-2">Standard Metropolitan Report</h3>
            <div class="card-price-2">
              <span class="fs-1">$19.99</span>/month
            </div>
            <p class="card-description-2">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus
              ultrices lorem quis magna efficitur, eu rhoncus eros aliquet.
            </p>
            <button class="btn btn-outline-primary btn-select">Select Plan</button>
          </div>
        </div> -->
      @foreach ($packages as $package)
      <div class="col-md-6 col-10">
        <div class="card-2 shadow p-4" style="min-height: 400px;">
          <h3 class="card-title-2">{{ $package->name }}</h3>
          <div class="card-price-2">
            <span class="fs-1">${{ number_format($package->price) }}</span>/Annually
          </div>
          <p class="card-description-2">{{ $package->description }}</p>
          <div class="card-body text-center w-100">
            @if ($package->package_type == 'state')
            <p>Four-Week Free Trial</p>
            <select class="form-select form-control mb-3 ">
              @foreach ($standard_report_list as $srl)
              <option>{{ $srl->name }}</option>
              @endforeach
            </select>
            @endif
          </div>
          @if (Auth::check())
          <button class="btn btn-outline-primary btn-select" onclick='window.location.href="/home"'>Select Plan</button>
          @else
          <button class="btn btn-outline-primary btn-select" onclick='window.location.href="/signup"'>Select Plan</button>
          @endif
        </div>
      </div>
      <!-- <div class="col-lg-6 col-md-12 mb-6">
                <div class="card h-100 shadow-lg">
                    <div class="card-body">
                        <div class="text-center p-3">
                            <h5 class="card-title h2">{{ $package->name }}</h5>
                            <br><br>
                            <span class="h1">${{ number_format($package->price) }}</span>/Annually
                            <br><br>
                        </div>
                        <p class="card-text">{{ $package->description }}</p>
                    </div>
                    <div class="card-body text-center">
                        @if ($package->package_type == 'state')
                            <p>Four-Week Free Trial</p>
                            <select class="form-select form-control mb-3 ">
                                @foreach ($standard_report_list as $srl)
                                    <option>{{ $srl->name }}</option>
                                @endforeach
                            </select>
                        @endif
                    </div>
                    <div class="card-body text-center">
                        @if (Auth::check())
                            <button class="btn btn-outline-primary btn-lg"
                                style="border-radius:20px" onclick='window.location.href="/home"'>Select</button>
                        @else
                            <button class="btn btn-outline-primary btn-lg"
                                style="border-radius:20px" onclick='window.location.href="/signup"'>Select</button>
                        @endif
                    </div>
                </div>
            </div> -->
      @endforeach

    </div>
  </div>

  <!-- plan section end -->

  @include('footer')

  <!-- Include Owl Carousel JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

  <script>
    $(document).ready(function() {
      $(".owl-carousel").owlCarousel({
        items: 1,
        loop: true,
        autoplay: true,
        animateIn: 'animate__fadeIn',
        autoplayTimeout: 5000,
        autoplayHoverPause: false,
        nav: true,
        navText: ["<i class='fa fa-chevron-left'></i>", "<i class='fa fa-chevron-right'></i>"]
      });
    });
  </script>


  <!-- bootstrap js cdns start-->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <!-- bootstrap js cdns ends-->
</body>

</html>
