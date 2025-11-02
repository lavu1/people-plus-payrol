<header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container position-relative d-flex align-items-center">

        <a href="{{ route('home') }}" class="logo d-flex align-items-center me-auto">
            <!-- Uncomment the line below if you also wish to use an image logo -->
            <!-- <img src="assets/img/logo.png" alt=""> -->
            <h1 class="sitename"><strong>People</strong></h1><span>+</span>
        </a>

        <nav id="navmenu" class="navmenu">
            <ul>
                <li><a href="{{ route('home') }}" class="{{ in_array(Route::currentRouteName(), ['home']) ? 'active' : '' }}">Home</a></li>
                <li class="dropdown"><a href="{{ route('about-us') }}" class="{{ in_array(Route::currentRouteName(), ['about-us']) ? 'active' : '' }}"><span>About</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
                    <ul>
                        <li><a href="{{ route('about-us') }}" class="{{ in_array(Route::currentRouteName(), ['about-us']) ? 'active' : '' }}">About</a> </li>
                        <li><a href="{{ route('team')}}" class="{{ in_array(Route::currentRouteName(), ['team']) ? 'active' : '' }}">Team</a></li>
                        <li><a href="{{ route('testimonials')}}" class="{{ in_array(Route::currentRouteName(), ['testimonials']) ? 'active' : '' }}">Testimonials</a></li>
{{--                        <li class="dropdown"><a href="#"><span>Deep Dropdown</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>--}}
{{--                            <ul>--}}
{{--                                <li><a href="#">Deep Dropdown 1</a></li>--}}
{{--                                <li><a href="#">Deep Dropdown 2</a></li>--}}
{{--                                <li><a href="#">Deep Dropdown 3</a></li>--}}
{{--                                <li><a href="#">Deep Dropdown 4</a></li>--}}
{{--                                <li><a href="#">Deep Dropdown 5</a></li>--}}
{{--                            </ul>--}}
{{--                        </li>--}}
                    </ul>
                </li>
                <li><a href="{{ route('services') }}" class="{{ in_array(Route::currentRouteName(), ['services']) ? 'active' : '' }}">Services</a></li>
                <li><a href="{{ route('portfolio') }}" class="{{ in_array(Route::currentRouteName(), ['portfolio']) ? 'active' : '' }}">Portfolio</a></li>
                <li><a href="{{ route('pricing') }}" class="{{ in_array(Route::currentRouteName(), ['pricing']) ? 'active' : '' }}">Pricing</a></li>
                <li><a href="{{ route('blog') }}" class="{{ in_array(Route::currentRouteName(), ['blog']) ? 'active' : '' }}">Blog</a></li>
                <li><a href="{{ route('csr') }}" class="{{ in_array(Route::currentRouteName(), ['csr']) ? 'active' : '' }}">Our CSR</a></li>
                <li><a href="{{ route('contact-us') }}" class="{{ in_array(Route::currentRouteName(), ['contact-us']) ? 'active' : '' }}">Contact</a></li>
                <li><a href="{{ route('sign-in') }}" class="{{ in_array(Route::currentRouteName(), ['sign-in']) ? 'active' : '' }}"><strong>Sign In</strong></a></li>
                <li><a href="/admin/login" class="{{ in_array(Route::currentRouteName(), ['sign-in']) ? 'active' : '' }}"><strong>FreePayroll App</strong></a></li>
            </ul>
            <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
        </nav>

        <div class="header-social-links">
            <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
            <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="linkedin"><i class="bi bi-linkedin"></i></a>
        </div>

    </div>
</header>
