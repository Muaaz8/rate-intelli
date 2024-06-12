 <!-- footer starts -->
 <footer class="footer">
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
                        <li><a href="{{ url('/') }}">Home</a></li>
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
