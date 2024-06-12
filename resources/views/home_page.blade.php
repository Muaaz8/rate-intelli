@extends('website_layout.app')

@section('title')
    Intelli-Rate
@endsection

@section('content')
    <!-- banner text div start -->
    <div class="banner-text">
        <h1>Our finance give more possibilites of <span class="banner-heading-style">bussiness</span></h1>
        <p>Lorem, ipsum dolor sit amet consectetur adipisicing elit. Distinctio, quos!. amet consectetur adipisicing
            elit. Distinctio, quos!</p>
        <div class="banner-border mb-4"></div>
        <button class="btn my-btn-outline-secondary">Connect With us</button>
    </div>
    <!-- banner text div ends -->
    </div>
    <!-- banner image div end -->
    </div>
    <!-- about div starts -->
    <div id="about" class="conatiner about-div my-5">

        <div class="container d-flex align-items-center justify-content-between">
            <div class="section-heading">
                <h6>INTRODUCTION</h6>
                <h1>About Us</h1>
                <div class="banner-border w-25"></div>
            </div>
            <p class="w-50 my-about-para">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Mollitia consequatur
                nobis earum
                enim doloremque iure, cum quo provident ipsam itaque facilis odio similique eveniet!</p>
        </div>

        <div class="container about-box my-4">
            <div class="row align-items-start justify-content-between">

                <div class="col-md-4 mb-4">
                    <div class="card mycard-tab h-100 border-0 active-box">
                        <div class="card-body">
                            <h5 class="card-title text-center fw-bold fs-5 my-card-text">Who we are</h5>
                            <div class="container">
                                <hr>
                            </div>
                            <p class="card-text my-card-text">BancAnalytics was founded in 1995 by experienced banking
                                executives and business professionals with a mission of improving data collection and
                                analytical systems to help financial institutions make more timely and impactful
                                decisions.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card mycard-tab h-100 border-0 shadow">
                        <div class="card-body">
                            <h5 class="card-title text-center fw-bold fs-5 my-card-text">What We Do</h5>
                            <div class="container">
                                <hr>
                            </div>
                            <p class="card-text my-card-text">BancAnalytics offers deposit rate intelligence reports
                                that provide users with timely, accurate data on competitor rates and how their
                                financial institution’s rates compare to the market. We offer broad market analyses by
                                metropolitan area weekly.</p>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card mycard-tab h-100 border-0 active-box2">
                        <div class="card-body">
                            <h5 class="card-title text-center fw-bold fs-5 my-card-text">What Sets Us Apart</h5>
                            <div class="container">
                                <hr>
                            </div>
                            <p class="card-text my-card-text">Our approach to data collection and analysis is to make
                                sure the data is accurate, comprehensive, timely, and relevant to our clients’ needs.
                                The platform is easy to navigate and data is presented so that clients can quickly drill
                                down.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
    <!-- about div ends -->

    <!-- products div starts  -->
    <div id="products" class="products-div py-5 mb-3">
        <div class="container d-flex align-items-center justify-content-center">
            <div class="section-heading text-center">
                <h6>Intelli-Rate by BancAnalytics</h6>
                <h1>Product Details</h1>
                <div class="banner-border w-25"></div>
            </div>
        </div>

        <div class="container my-5">
            <div class="row">

                <div class="col-lg-4 col-md-4 col-12 mt-2">
                    <summary
                        class="min-card-height my-card-hover d-flex align-items-center justify-content-center text-center flex-column border border-1 shadow-sm rounded-3 p-4 mt-2">
                        <div class="icon-circle">
                            <img src="{{ asset('img/growth-chart.png') }}" alt="Icon" class="icon-image">
                        </div>
                        <h4 class="mt-5">Report Features</h4>
                        <div class="container">
                            <hr>
                        </div>
                        <p class="my-card-text">
                            The APY Rankings Report ranks institutions by APY, shows weekly changes, and includes market
                            stats. Users
                            can highlight, filter, and generate PDFs. Special promotions and a Summary Report rank
                            institutions by APY.
                            Multiple users can access via "Manage Users" tab.
                        </p>
                    </summary>
                </div>

                <div class="col-lg-4 col-md-4 col-12 mt-2">
                    <summary
                        class="min-card-height my-card-hover d-flex align-items-center justify-content-center text-center flex-column border border-1 shadow-sm rounded-3 p-4 mt-2">
                        <div class="icon-circle">
                            <img src="{{ asset('img/growth-chart.png') }}" alt="Icon" class="icon-image">
                        </div>
                        <h4 class="mt-5">Report Features</h4>
                        <div class="container">
                            <hr>
                        </div>
                        <p class="my-card-text">
                            The APY Rankings Report ranks institutions by APY, shows weekly changes, and includes market
                            stats. Users
                            can highlight, filter, and generate PDFs. Special promotions and a Summary Report rank
                            institutions by APY.
                            Multiple users can access via "Manage Users" tab.
                        </p>
                    </summary>
                </div>

                <div class="col-lg-4 col-md-4 col-12 mt-2">
                    <summary
                        class="min-card-height my-card-hover d-flex align-items-center justify-content-center text-center flex-column border border-1 shadow-sm rounded-3 p-4 mt-2">
                        <div class="icon-circle">
                            <img src="{{ asset('img/growth-chart.png') }}" alt="Icon" class="icon-image">
                        </div>
                        <h4 class="mt-5">Report Features</h4>
                        <div class="container">
                            <hr>
                        </div>
                        <p class="my-card-text">
                            The APY Rankings Report ranks institutions by APY, shows weekly changes, and includes market
                            stats. Users
                            can highlight, filter, and generate PDFs. Special promotions and a Summary Report rank
                            institutions by APY.
                            Multiple users can access via "Manage Users" tab.
                        </p>
                    </summary>
                </div>


            </div>
        </div>


    </div>
    <!-- products div ends  -->

    <!-- plans div starts  -->
    <div id="plans" class="py-5 mb-3">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="container text-center">
                <div class="section-heading mb-4">
                    <h6>Get Started Now</h6>
                    <h1 class="display-5 fw-bold">Select Your Plan</h1>
                    <div class="banner-border w-25 mx-auto"></div>
                </div>
                <p class="lead my-about-para">Choose from our subscription plans to access comprehensive reports
                    tailored to your needs.</p>
            </div>
        </div>

        <!-- <div class="container  my-4">
                <hr>
            </div> -->

        <div class="container mt-5">
            <div class="row d-flex align-items-center justify-content-center">
                @foreach ($packages as $package)
                    <div class="col-md-4 mt-3" >
                        <summary style="min-height: 400px;"
                            class="min-card-height d-flex align-items-center justify-content-center text-center flex-column border border-1 shadow-sm rounded-3 p-4 plan-card">
                            <h4 class="fs-5 fw-bold mb-0">{{ $package->name }}</h4>
                            <div class="w-75">
                                <hr>
                            </div>
                            <h3 class="fs-6"><span class="fs-3">${{ number_format($package->price) }}</span>/Annually
                            </h3>
                            <p class="font-extra-small">{{ $package->description }}
                                @if ($package->package_type == 'state')
                                    <br>
                                    Four-Week Free Trial
                                @endif
                            </p>
                            @if ($package->package_type == 'state')
                                <div class="input-group mb-3">
                                    <select class="form-select" id="inputGroupSelect02">
                                        @foreach ($standard_report_list as $srl)
                                            <option>{{ $srl->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                            @if (Auth::check())
                                <button class="btn btn-outline-primary btn-select" onclick='window.location.href="/home"'>Select Plan</button>
                            @else
                                <button class="btn btn-outline-primary btn-select" onclick='window.location.href="/signup"'>Select Plan</button>
                            @endif
                        </summary>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
    <!-- plans div ends  -->

    <div class="container">
        <div class="divider"></div>
    </div>

    {{-- <!-- Feedback div starts  -->
    <div id="feedback" class="py-5">
        <div class="container d-flex align-items-center justify-content-between">
            <div class="section-heading">
                <h6>Give your suggestions</h6>
                <h1>Feedback</h1>
                <div class="banner-border w-25"></div>
            </div>
        </div>

        <div class="feedback-form container width-70 mt-4">
            <form action="#" method="post">
                <label for="name">Your Name:</label>
                <input type="text" id="name" name="name" required>

                <label for="email">Your Email:</label>
                <input type="email" id="email" name="email" required>

                <label for="feedback">Your Feedback:</label>
                <textarea id="feedback" name="feedback" rows="4" required></textarea>

                <button type="submit">Submit</button>
            </form>
        </div>

    </div>
    <!-- Feedback div ends  --> --}}
@endsection
