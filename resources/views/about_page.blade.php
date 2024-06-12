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
        .divider {
            width: 100%;
            height: 2px;
            background: linear-gradient(to right, #0049ff, #009fff, #00dbff, #28e8ff);
            margin: 20px 0;
            position: relative;
        }

        .divider::before,
        .divider::after {
            content: '';
            width: 20px;
            height: 20px;
            background-color: #0049ff;
            position: absolute;
            border: 2px solid #fff;
            border-radius: 50%;
            transform: translateY(-50%);
        }

        .divider::before {
            top: 0;
            left: 0;
        }

        .divider::after {
            top: 0;
            right: 0;
        }


        /* ///////////////////// */

        .divider2 {
            width: 100%;
            height: 2px;
            background-color: #ccc;
            margin: 20px 0;
            position: relative;
        }

        .divider2::before {
            content: '';
            width: 20px;
            height: 20px;
            background-color: #fff;
            position: absolute;
            top: -9px;
            left: 50%;
            transform: translateX(-50%);
            border: 2px solid #ccc;
            border-radius: 50%;
        }

        .divider2::after {
            content: '';
            width: 20px;
            height: 20px;
            background-color: #fff;
            position: absolute;
            bottom: -9px;
            left: 50%;
            transform: translateX(-50%);
            border: 2px solid #ccc;
            border-radius: 50%;
        }
    </style>
    <title>About</title>
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

        <h2 class="centered_h1_bold_2 p-4 ">About</h2>

    </div>


    <!-- news section starts  -->

    <div class="container ">
        <div class="row p-4 mt-5 mb-5 rounded-5 shadow-sm news_box text-justify">
            <h3>Who We Are :</h3>
            <p class="fs-5">BancAnalytics was founded in 1995 by experienced banking executives and business professionals with a mission of improving data collection and analytical systems to help financial institutions make more timely and impactful decisions.</p>
            <div class="divider"></div>
            <h3>What We Do :</h3>
            <p class="fs-5">BancAnalytics offers deposit rate intelligence reports that provide users with timely, accurate data on competitor rates and how their financial institution’s rates compare to the market. We offer broad market analyses by metropolitan area and encourage our clients to take time to consider who they are truly competing with in that area and beyond. If clients decide they want a more narrow focus, we can tailor affordable, customized solutions to meet their needs. Learn more about Intelli-Rate formerly known as Money Monitor in the product details section.</p>
            <div class="divider"></div>
            <h3>What Sets Us Apart :</h3>
            <p class="fs-5">There are other companies that provide data collection and some that provide templates for completing data analysis tasks. What sets BancAnalytics apart is the experience we bring as financial institution executives and business leaders. Our approach to data collection is to make sure the data is accurate, comprehensive, timely, and relevant to our clients’ needs. Our approach to data analysis is unique in that we employ proprietary methods along with presentation techniques that allow users to quickly drill down and identify opportunities as well as potential areas of concern. This process often leads users to ascertain ways to improve operating performance.</p>

        </div>
    </div>

    <!-- news section end  -->


    <!-- product details section starts -->

    <div class="container ">

        <h1 class="banner_heading text-left fw-bolder" id="product_details">Product Details</h1>

        <hr>
        <div class="row p-4 fs-6 mt-5 mb-5 rounded-5 shadow-sm news_box text-justify">

            <h3 class="text-left">Report Features</h3>


            <div class="col-md-12">
                <ul>
                    <li>Annual Percentage Yield (APY) Rankings Report: </li>

                    <ul>
                        <li>Institutions are ranked high to low for each product
                            surveyed. Changes from previous week to current APY
                            are indicated. </li>
                        <li>Market highs, lows, mean, median, and mode are
                            summarized for each of the products surveyed. </li>
                        <li>Ability to highlight selected institutions, filter by institution
                            type, and generate a PDF to present to the Management
                            Team and Board Members. </li>
                    </ul>
                    <li>Special Promotions:</li>
                    <ul>
                        <li>Products requiring higher deposit amounts or other
                            relationships are ranked high to low by APY. </li>
                    </ul>
                    <li>Summary Report: </li>
                    <ul>
                        <li>Determine how your institution or your competitors rank
                            across all products in one easy to read summary. </li>
                        <li>Highlight selected institutions and/or filter by institution
                            type. </li>
                    </ul>
                    <li>Allow multiple members of your Management Team access
                        through the “Manage Users” tab. </li>

                </ul>
            </div>

            <div class="divider2"></div>

            <h3 class="text-left">Peer Group Averages & Graphs</h3>

            <div class="col-md-12">

                <ul>
                    <li>Enables financial institutions to compare their own rates with
                        those of similar institutions within the same market. This
                        benchmarking helps institutions gauge their competitiveness and
                        performance relative to their peers. </li>
                    <li>The Dashboard contains full-color graphs enhances the visual
                        representation of data, making it easier for clients to identify
                        trends and patterns at a glance. </li>
                </ul>
            </div>

            <div class="col-md-12">

                <div class="divider2"></div>

                <h3>Product Details
                    Summary:</h3>
                <ul>
                    <li>Weekly, personal deposit yield report </li>
                    <ul>
                        <li>Savings, Money Market, CDs, Promotions </li>
                    </ul>
                    <li>Rankings of institutions </li>
                    <li>Changes and statistics calculated </li>
                    <li>Full-color graphs </li>
                    <li>Comprehensive metropolitan areas or customized for your
                        market </li>
                    <li>Reliable and affordable </li>
                </ul>
            </div>


        </div>
    </div>


    <!-- product details section ends -->

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
