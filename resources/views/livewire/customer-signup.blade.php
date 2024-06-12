    <div class="signup">
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
          </ul>

          <!-- <div>
              <a href="/signup.html" class="btn btn-outline-primary max_contant">Sign Up</a>
              <a href="/login.html" class="btn btn-secondary max_contant">Login</a>
            </div> -->
        </div>
      </div>
      <!-- header ends  -->

      <!-- signup section starts  -->

      <!-- /////////////////////////////////////// -->
      <!-- /////////////////////////////////////// -->
      <!-- /////////////////////////////////////// -->
      <div class="container-fluid ">
        <div class="col-md-8  m-auto ">
          <div class="main_signUp m-5">
            <h1 class="regiter_heading_main text-center p-4 w-100">Tell Us About You</h1>
            <div class="row p-4">
              <form wire:submit.prevent="submitForm">
                <div class="col-md-12">
                  <div>

                    <div>
                      <div class="row">
                        @error('error')
                        <div class="mt-4 text-center">
                          <span class="alert alert-danger">{{$message}}</span>
                        </div>
                        @enderror

                        <div class="col-md-4">
                          <div class="mb-3">
                            <label for="bank_name" class="form-label font_wright_500">Institution
                              Name</label>
                            <input type="name" id="bank_name" name="bank_name" class="form-control" aria-describedby="name" placeholder="BancAnalytics" wire:model.lazy="bank_name" required>
                            <!-- <div id="name" class="form-text">error message</div> -->
                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="mb-3">
                            <label for="bank_phone" class="form-label font_wright_500">Main Phone
                              Number</label>
                            <input type="text" id="bank_phone" name="bank_phone" class="form-control" aria-describedby="phone" maxlength="12" wire:model.lazy="bank_phone" required placeholder="949-656-3133">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="mb-3">
                            <label for="bank_website" class="form-label font_wright_500">Website </label>
                            <input type="text" id="bank_website" name="bank_website" class="form-control" aria-describedby="website" wire:model.lazy="bank_website" required placeholder="Your Website">

                          </div>
                        </div>

                        <div class="col-md-4">
                          <div class="mb-3">
                            <label for="zip_code" class="form-label font_wright_500">Zip Code</label>
                            <input type="text" id="zip_code" name="zip_code" class="form-control" aria-describedby="website" wire:model="zip_code" wire:keyup="fetch_zip_code" required placeholder="Your Zip Code">
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="mb-3">
                            <label for="bank_state" class="form-label font_wright_500">State</label>
                            <select class="form-select" id="bank_state" name="bank_state" aria-label="Default select example" wire:model.lazy="bank_state" disabled required>
                              <option value=""> </option>
                              @foreach ($states as $state)
                              <option value="{{ $state->id }}">{{ $state->name }}
                              </option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="mb-3">
                            <label for="bank_state" class="form-label font_wright_500">City</label>
                            <select class="form-select" id="bank_city" name="bank_city" aria-label="Default select example" wire:model.lazy="bank_city" disabled required>
                              <option value=""> </option>
                              @if ($bank_cities != null)
                              @foreach ($bank_cities as $city)
                              <option value="{{ $city->id }}">{{ $city->name }}
                              </option>
                              @endforeach
                              @endif
                            </select>
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="mb-3">
                            <label for="zip_code" class="form-label font_wright_500">Billing Address</label>
                            <input type="text" id="billing_address" name="billing_address" class="form-control" aria-describedby="website" wire:model="billing_address" required placeholder="Street / PO Box">
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                  <hr>
                  <div>
                    <h5 class="admin_heading pt-2 pb-2 fw-bold blue_dark">Administrator Information</h5>
                    <div>
                      <div class="row">
                        <div class="col-md-4">
                          <div class="mb-3">
                            <label for="admin_first_name" class="form-label font_wright_500">First
                              Name</label>
                            <input type="name" id="admin_first_name" name="admin_first_name" class="form-control" aria-describedby="name" wire:model.lazy="admin_first_name" required placeholder="First Name">
                            <!-- <div id="name" class="form-text">error message</div> -->
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="mb-3">
                            <label for="admin_last_name" class="form-label font_wright_500">Last
                              Name</label>
                            <input type="name" id="admin_last_name" name="admin_last_name" class="form-control" aria-describedby="name" wire:model.lazy="admin_last_name" placeholder="Last Name" required>
                            <!-- <div id="name" class="form-text">error message</div> -->
                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="mb-3">
                            <label for="admin_email" class="form-label font_wright_500">Email
                              Address</label>
                            <input type="email" id="admin_email" name="admin_email" class="form-control" aria-describedby="email" placeholder="Contact Person Email Address" wire:model.lazy="admin_email" required>

                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="mb-3">
                            <label for="admin_phone" class="form-label font_wright_500">Direct Phone
                              Number</label>
                            <input type="text" id="admin_phone" name="admin_phone" class="form-control" aria-describedby="phone" maxlength="12" wire:model.lazy="admin_phone" required placeholder="949-656-3133">

                          </div>
                        </div>
                        <div class="col-md-4">
                          <div class="mb-3">
                            <label for="admin_designation" class="form-label font_wright_500"> Title</label>
                            <input type="text" id="admin_designation" name="admin_designation" class="form-control" aria-describedby="Designation" placeholder="Job Title" wire:model.lazy="admin_designation" required>

                          </div>
                        </div>

                      </div>

                    </div>
                  </div>
                  <hr>


                  <div>

                    <div>
                      <div class="row">

                        <div class="col-md-12">
                          <div class="mb-3 text-center">
                            <button type="submit" class="btn gradient btn-primary btn-lg submit_btn">Next</button>
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


        <!-- /////////////////////////////////////// -->
        <!-- /////////////////////////////////////// -->
        <!-- /////////////////////////////////////// -->

        <!-- signup section ends  -->
      </div>

      <!-- footer starts -->
      <footer class="footer2">
        <div class="container">
          <div class="row d-flex align-items-start justify-content-between">
            <div class="col-lg-3 col-md-6 col-sm-6">
              <div class="footer__about">
                <div class="footer__logo">
                <img src="./assets/logo/logo-white.png" alt="Logo" width="250" />
                </div>
                <p>
                  BancAnalytics was founded in 1995 by experienced banking
                  executives and business professionals with a mission of
                  improving data collection and analytical systems to help
                  financial institutions make more timely and impactful decisions.
                </p>
              </div>

              <div class="footer__about">
                <div class="footer__widget">
                  <h3>Contact Us</h3>
                </div>
                <p>
                    <strong>BancAnalytics Corporation</strong> <br />
                    <strong>Address:</strong> <br> 12430 Tesson Ferry Road, <br>
                    Suite #241, <br>
                    St. Louis, MO 63128, <br>
                    <strong>Email:</strong> support@bancanalytics.com
                  </p>
              </div>
            </div>

            <div class="col-lg-2 col-md-3 col-sm-6"></div>
            <div class="col-lg-2 col-md-3 col-sm-6">
              <div class="footer__widget">
                <h3>Quick Links</h3>
                <ul class="text-left">
                  <li><a href="#">Home</a></li>
                  <li><a href="{{ route('interesting_stories') }}">News</a></li>
                  <li><a href="{{ route('view_feedback') }}">Feedback</a></li>
                  <li><a href="{{ route('about_page') }}">About</a></li>
                </ul>
              </div>
            </div>
            <div class="col-lg-3 offset-lg-1 col-md-6 col-sm-6">
              <div class="footer__widget">
                <h3>Subscribe</h3>
                <div class="footer__newslatter">
                  <p>
                    Don’t miss out. Subscribe to our feeds. Enter your email address below.
                  </p>
                  <form action="#">
                    <input type="text" placeholder="Your email" />
                    <button type="submit">
                      <span class="icon_mail_alt"></span>
                    </button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="col-lg-12 text-center">
          <div class="footer__copyright__text">
            <p>
              Copyright ©
              <script>
                document.write(new Date().getFullYear());
              </script>
              , All Right Reserved <b>INTELLI-RATE</b>
            </p>
          </div>
        </div>
      </footer>
      <!-- footer end -->

    </div>
