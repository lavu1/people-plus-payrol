
<footer id="footer" class="footer dark-background">

    <div class="container footer-top">
        <div class="row gy-4">
            <div class="col-lg-4 col-md-6 footer-about">
                <a href="/" class="logo d-flex align-items-center">
                    <span class="sitename">Peoples Plus</span>
                </a>
                <div class="footer-contact pt-3">
                    <p> Stand 3938, Along Nile Avenue,</p>
                    <p>Riverside, Kitwe, Zambia</p>
                    <p class="mt-3"><strong>Phone:</strong> <span>0977 762 709 / 0963 719 725</span></p>
                    <p><strong>Email : </strong> <span> ppmsolutions24@gmail.com</span></p>
                </div>
                <div class="social-links d-flex mt-4">
                    <a href=""><i class="bi bi-twitter-x"></i></a>
                    <a href=""><i class="bi bi-facebook"></i></a>
                    <a href=""><i class="bi bi-instagram"></i></a>
                    <a href=""><i class="bi bi-linkedin"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Useful Links</h4>
                <ul>
                    <li><a href="/">Home</a></li>
                    <li><a href="{{ route('about-us') }}">About us</a></li>
                    <li><a href="{{ route('services') }}">Services</a></li>
                    <li><a href="#">Terms of service</a></li>
                    <li><a href="#">Privacy policy</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-3 footer-links">
                <h4>Our Services</h4>
                <ul>
                    <li><a href="#">Management Consulting</a></li>
                    <li><a href="#">Human Resources</a></li>
                    <li><a href="#">Accounting, Bookkeeping & Tax</a></li>
                    <li><a href="#">Counselling, Advisory & Administrative Services</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-12 footer-newsletter">
                <h4>Our Newsletter</h4>
                <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
                <form action="forms/newsletter.php" method="post" class="php-email-form">
                    <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
                    <div class="loading">Loading</div>
                    <div class="error-message"></div>
                    <div class="sent-message">Your subscription request has been sent. Thank you!</div>
                </form>
            </div>

        </div>
    </div>

    <div class="container copyright text-center mt-4">
        <p>© <span>Copyright</span> <strong class="px-1 sitename">Peoples Plus Payroll</strong> 2025<span>All Rights Reserved</span></p>
        <div class="credits">
            <!-- All the links in the footer should remain intact. -->
            <!-- You can delete the links only if you've purchased the pro version. -->
            <!-- Licensing information: https://bootstrapmade.com/license/ -->
            <!-- Purchase the pro version with working PHP/AJAX contact form: [buy-url] -->
            Designed by <a href="#">Alphil Networks Limited</a> Distributed by <a href=“/">Peoples Plus Payroll</a>
        </div>
    </div>

</footer>
