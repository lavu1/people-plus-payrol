@extends('layouts.app')
@section('page_title', 'Our Services | Peoples Plus')
@section('content')
    <!-- Page Title -->
    <div class="page-title accent-background">
        <div class="container d-lg-flex justify-content-between align-items-center">
            <h1 class="mb-2 mb-lg-0">Sign in Details</h1>
            <nav class="breadcrumbs">
                <ol>
                    <li><a href="/">Home</a></li>
                    <li class="current">System Details</li>
                </ol>
            </nav>
        </div>
    </div><!-- End Page Title -->

    <!-- Portfolio Details Section -->
    <section id="portfolio-details" class="portfolio-details section">

        <div class="container" data-aos="fade-up">

            <div class="row justify-content-between gy-4 mt-4">

                <div class="col-lg-8" data-aos="fade-up">
                    <div class="portfolio-description">
                        <h2>HR Management & Payroll System</h2>
                        <p>
                            Our comprehensive HR system provides end-to-end workforce management solutions designed to streamline your HR operations. The platform offers intuitive organization setup with hierarchical structure management for enterprises of all sizes.
                        </p>
                        <p>
                            The system follows a logical setup flow: After administrator login, you first create your company profile, then establish branches or departments. This structured approach ensures proper data organization from the start.
                        </p>

                        <div class="testimonial-item">
                            <p>
                                <i class="bi bi-quote quote-icon-left"></i>
                                <span>This system transformed our HR operations. The step-by-step company setup made deployment effortless, and the branch-level controls gave us perfect granularity for our multi-location business.</span>
                                <i class="bi bi-quote quote-icon-right"></i>
                            </p>
                            <div>
                                <img src="assets/img/testimonials/testimonials-2.jpg" class="testimonial-img" alt="">
                                <h3>Michael Johnson</h3>
                                <h4>HR Director</h4>
                            </div>
                        </div>

                        <p>
                            Key setup steps after initial login include: Company profile creation, branch/department establishment, followed by detailed configuration of payroll structures, leave policies, and role-based access controls. The system grows with your organization.
                        </p>

                        <p>
                            Once configured, administrators can manage the full employee lifecycle - from onboarding to exit processing. Department heads get customized dashboards while employees enjoy self-service access to their information, creating a complete HR ecosystem.
                        </p>

                    </div>
                </div>

                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="100">
                    <div class="portfolio-info">
                        <h3>System information</h3>
                        <ul>
                            <li><strong>Category</strong> HR Technology</li>
                            <li><strong>Client</strong> Enterprise Solutions</li>
                            <li><strong>Launch date</strong> 15 January, 2023</li>
                            <li><strong>System URL</strong> <a href="/admin/login">https://peoplesplussolution.com/admin/login</a></li>
                            <li><a href="#" class="btn-visit align-self-start">Visit Portal</a></li>
                        </ul>
                    </div>
                </div>

            </div>

            <div class="portfolio-details-slider swiper init-swiper">
                <script type="application/json" class="swiper-config">
                    {
                      "loop": true,
                      "speed": 600,
                      "autoplay": {
                        "delay": 5000
                      },
                      "slidesPerView": "auto",
                      "navigation": {
                        "nextEl": ".swiper-button-next",
                        "prevEl": ".swiper-button-prev"
                      },
                      "pagination": {
                        "el": ".swiper-pagination",
                        "type": "bullets",
                        "clickable": true
                      }
                    }
                </script>
                <div class="swiper-wrapper align-items-center">

                    <div class="swiper-slide">
                        <img src="assets/img/portfolio/app-1.jpg" alt="">
                    </div>

{{--                    <div class="swiper-slide">--}}
{{--                        <img src="assets/img/portfolio/product-1.jpg" alt="">--}}
{{--                    </div>--}}

{{--                    <div class="swiper-slide">--}}
{{--                        <img src="assets/img/portfolio/branding-1.jpg" alt="">--}}
{{--                    </div>--}}

                    <div class="swiper-slide">
                        <img src="assets/img/portfolio/books-1.jpg" alt="">
                    </div>

                </div>
                <div class="swiper-button-prev"></div>
                <div class="swiper-button-next"></div>
                <div class="swiper-pagination"></div>
            </div>


        </div>

    </section><!-- /Portfolio Details Section -->
@endsection
