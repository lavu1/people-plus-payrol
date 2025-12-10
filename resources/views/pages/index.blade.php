@extends('layouts.app')
@section('page_title', 'Home page | Peoples Plus')
@section('content')
    <!-- Hero Section -->
    <section id="hero" class="hero section dark-background">

        <div id="hero-carousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-interval="5000">

            <div class="carousel-item active">
                <img src="assets/img/hero-carousel/Gemini_Generated_Image_4qe1854qe1854qe1.png" alt="">
                <div class="container">
                    <h2>Expert Management Solutions for Your Business</h2>
                    <p>Streamline your operations with our professional consultancy services. From HR to financial management, we help organizations achieve their goals.</p>
                    <a href="{{ route('sign-in') }}" class="btn-get-started">Explore Our Services</a>
                </div>
            </div><!-- End Carousel Item -->

            <div class="carousel-item">
                <img src="assets/img/hero-carousel/Gemini_Generated_Image_kjbjzukjbjzukjbj.png" alt="">
                <div class="container">
                    <h2>Comprehensive Financial & Tax Services</h2>
                    <p>Leave financial complexities to us! We ensure accurate, timely, and compliant financial processing so you can focus on business growth.</p>
                    <a href="{{ route('sign-in') }}" class="btn-get-started">Learn About Our Services</a>
                </div>
            </div><!-- End Carousel Item -->

            <div class="carousel-item">
                <img src="assets/img/hero-carousel/Gemini_Generated_Image_rt2u1lrt2u1lrt2u.png" alt="">
                <div class="container">
                    <h2>Trusted by Leading Organizations</h2>
                    <p>Join numerous businesses and institutions that rely on our expertise for seamless management solutions.</p>
                    <a href="#" class="btn-get-started">Get Started Today</a>
                </div>
            </div>

            <a class="carousel-control-prev" href="#hero-carousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon bi bi-chevron-left" aria-hidden="true"></span>
            </a>

            <a class="carousel-control-next" href="#hero-carousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon bi bi-chevron-right" aria-hidden="true"></span>
            </a>

            <ol class="carousel-indicators"></ol>

        </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

        <div class="container">

            <div class="row position-relative">

                <div class="col-lg-7 about-img" data-aos="zoom-out" data-aos-delay="200"><img src="assets/img/ours.png"></div>

                <div class="col-lg-7" data-aos="fade-up" data-aos-delay="100">
                    <h2 class="inner-title"> Who We Are</h2>
                    <div class="our-story justify-content">
                        <h4>Since 2024</h4>
                        <h3>Our Story</h3>
                        <p class="text-start text-justify  " style="text-align: justify !important;">Founded in 2024, People-Plus Management Solutions is a management
                            consultancy firm dedicated to the provision of professional, relevant,
                            responsive and creative solutions to help organisations and individuals to
                            achieve their goals. based in Kitwe, People-Plus has a team of dedicated
                            professionals, supported by a network of associate Consultants based on
                            the Copperbelt and Lusaka Provinces of Zambia, and also in South Africa.
                            We are passionate about providing relevant management Solutions, with a
                            special focus on immigration and Travel advisory services.</p>
{{--                        <ul>--}}
{{--                            <li><i class="bi bi-check-circle"></i> <span>Expert HR Consultants</span></li>--}}
{{--                            <li><i class="bi bi-check-circle"></i> <span>Accurate & Timely Payroll Processing</span></li>--}}
{{--                            <li><i class="bi bi-check-circle"></i> <span>Compliance with Labor Laws</span></li>--}}
{{--                            <li><i class="bi bi-check-circle"></i> <span>Customized Solutions for Every Business</span></li>--}}
{{--                        </ul>--}}
{{--                        <p>To empower businesses with efficient HR and payroll solutions that drive growth and employee satisfaction.</p>--}}

{{--                        <div class="watch-video d-flex align-items-center position-relative">--}}
{{--                            <i class="bi bi-play-circle"></i>--}}
{{--                            <a href="https://www.youtube.com/watch?v=BgvQsA27sMQ" class="glightbox stretched-link">Watch Video</a>--}}
{{--                        </div>--}}
                    </div>
                </div>

            </div>

        </div>

    </section><!-- /About Section -->

    <section id="services" class="services section light-background">

        <div class="container">

            <div class="row gy-4">

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
                    <div class="service-item item-cyan position-relative">
                        <div class="icon">
                            <i class="bi bi-people"></i>
                        </div>
                        <a href="#" class="stretched-link">
                            <h3>Human Resources Management</h3>
                        </a>
                        <p>Comprehensive HR solutions including organizational design, policies drafting, manpower planning, and recruitment.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-item item-orange position-relative">
                        <div class="icon">
                            <i class="bi bi-calculator"></i>
                        </div>
                        <a href="#" class="stretched-link">
                            <h3>Accounting & Tax Services</h3>
                        </a>
                        <p>Professional accounting, bookkeeping, tax preparation, and financial advisory services for businesses.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
                    <div class="service-item item-teal position-relative">
                        <div class="icon">
                            <i class="bi bi-building"></i>
                        </div>
                        <a href="#" class="stretched-link">
                            <h3>Organizational Development</h3>
                        </a>
                        <p>Strategic planning, change management, and business process reengineering to improve efficiency.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="400">
                    <div class="service-item item-red position-relative">
                        <div class="icon">
                            <i class="bi bi-mortarboard"></i>
                        </div>
                        <a href="#" class="stretched-link">
                            <h3>Higher Education Management</h3>
                        </a>
                        <p>Specialized services for educational institutions including compliance, financing, and program development.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="500">
                    <div class="service-item item-indigo position-relative">
                        <div class="icon">
                            <i class="bi bi-laptop"></i>
                        </div>
                        <a href="#" class="stretched-link">
                            <h3>ICT Solutions</h3>
                        </a>
                        <p>Information technology and systems solutions to support your digital transformation needs.</p>
                    </div>
                </div><!-- End Service Item -->

                <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="600">
                    <div class="service-item item-pink position-relative">
                        <div class="icon">
                            <i class="bi bi-file-earmark-text"></i>
                        </div>
                        <a href="#" class="stretched-link">
                            <h3>Legal & Compliance</h3>
                        </a>
                        <p>Expert advice on labor law, employment contracts, industrial relations, and regulatory compliance.</p>
                    </div>
                </div><!-- End Service Item -->

            </div>

        </div>

    </section><!-- /Services Section -->
    <!-- Portfolio Section -->
    <section id="portfolio" class="portfolio section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Our Expertise</h2>
            <p>We provide diversified management consultancy services to support and meet our clients' needs across multiple sectors.</p>
        </div><!-- End Section Title -->

    </section><!-- /Portfolio Section -->

    <!-- Clients Section -->
    <section id="clients" class="clients section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Our Accreditations</h2>
            <p>Registered with key institutions to serve both public and private sector clients.</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">
            <div class="row g-0 clients-wrap">
                <div class="col-xl-2 col-md-4 client-logo">
                    <img src="assets/img/blog/zppa.jpeg" class="img-fluid" alt="Zambia Public Procurement Authority">
                </div>
                <div class="col-xl-2 col-md-4 client-logo">
                    <img src="assets/img/blog/zra.png" class="img-fluid" alt="Zambia Revenue Authority">
                </div>
                <div class="col-xl-2 col-md-4  client-logo">
                    <img src="assets/img/blog/pacra.png" class="img-fluid" alt="Patents and Companies Registration Agency">
                </div>
                <div class="col-xl-2 col-md-4  client-logo">
                    <img src="assets/img/blog/zihrm.png" class="img-fluid" alt="Zambia Institute of Human Resource Management">
                </div>
                <div class="col-xl-2 col-md-4  client-logo">
                    <img src="assets/img/blog/ndcc.png" class="img-fluid" alt="Ndola and District Chamber of Commerce and Industry">
                </div>
                <div class="col-xl-2 col-md-4  client-logo">
                    <img src="assets/img/blog/wcfcb.png" class="img-fluid" alt=" Workers Compensation Fund Control Board">
                </div>
                <div class="col-xl-2 col-md-4  client-logo">
                    <img src="assets/img/blog/napsa.png" class="img-fluid" alt="National Pension Scheme Authority - NAPSA">
                </div>
            </div>
        </div>

    </section><!-- /Clients Section -->
    <!-- Clients Section -->
    <section id="clients" class="clients section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Clients</h2>
            <p>Trusted by forward-thinking companies, our HR and payroll system delivers reliability and innovation.</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up" data-aos-delay="100">

            <div class="row g-0 clients-wrap">

                <div class="col-xl-3 col-md-4 client-logo">
                    <img src="assets/img/clients/img_1.png" class="img-fluid" alt="">
                </div><!-- End Client Item -->

                <div class="col-xl-3 col-md-4 client-logo">
                    <img src="assets/img/clients/img_2.png" class="img-fluid" alt="">
                </div><!-- End Client Item -->

                <div class="col-xl-3 col-md-4 client-logo">
                    <img src="assets/img/clients/img_3.png" class="img-fluid" alt="">
                </div><!-- End Client Item -->

                <div class="col-xl-3 col-md-4 client-logo">
                    <img src="assets/img/clients/img.png" class="img-fluid" alt="">
                </div><!-- End Client Item -->

{{--                <div class="col-xl-3 col-md-4 client-logo">--}}
{{--                    <img src="assets/img/clients/client-5.png" class="img-fluid" alt="">--}}
{{--                </div>--}}

{{--                <div class="col-xl-3 col-md-4 client-logo">--}}
{{--                    <img src="assets/img/clients/client-6.png" class="img-fluid" alt="">--}}
{{--                </div>--}}

{{--                <div class="col-xl-3 col-md-4 client-logo">--}}
{{--                    <img src="assets/img/clients/client-7.png" class="img-fluid" alt="">--}}
{{--                </div>--}}

{{--                <div class="col-xl-3 col-md-4 client-logo">--}}
{{--                    <img src="assets/img/clients/client-8.png" class="img-fluid" alt="">--}}
{{--                </div>--}}

            </div>

        </div>

    </section><!-- /Clients Section -->
@endsection
